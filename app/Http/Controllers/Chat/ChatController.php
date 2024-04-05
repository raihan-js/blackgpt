<?php

namespace App\Http\Controllers\Chat;

use LLPhant\Chat\Message;
use LLPhant\OpenAIConfig;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use LLPhant\Chat\OpenAIChat;
use LLPhant\Chat\Enums\ChatRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\ConversationHistory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\Response;
use LLPhant\Embeddings\DataReader\FileDataReader;
use LLPhant\Query\SemanticSearch\QuestionAnswering;
use Symfony\Component\HttpFoundation\StreamedResponse;
use LLPhant\Embeddings\DocumentSplitter\DocumentSplitter;
use LLPhant\Embeddings\EmbeddingFormatter\EmbeddingFormatter;
use LLPhant\Embeddings\VectorStores\FileSystem\FileSystemVectorStore;
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAIADA002EmbeddingGenerator;

class ChatController extends Controller
{
    public function chatView(){
        return view('chat.chat');
    }

    public function chatCompletion(Request $request): JsonResponse
    {
        $openaiService = config('services.openai');
        $config = new OpenAIConfig();
        $config->apiKey = $openaiService['api_key'];
        $chat = new OpenAIChat($config);
    
        try {
            // Setup for file vector store and embedding generator
            $filesVectorStore = new FileSystemVectorStore();
            $embeddingGenerator = new OpenAIADA002EmbeddingGenerator();
    
            // Load documents if vector store is empty
            if ($filesVectorStore->getNumberOfDocuments() === 0) {
                $dataReader = new FileDataReader(__DIR__.'/context.txt');
                $documents = $dataReader->getDocuments();
                $splittedDocuments = DocumentSplitter::splitDocuments($documents, 2000);
                $formattedDocuments = EmbeddingFormatter::formatEmbeddings($splittedDocuments);
    
                $embeddedDocuments = $embeddingGenerator->embedDocuments($formattedDocuments);
                $filesVectorStore->addDocuments($embeddedDocuments);
            }
    
            // Custom system message setup
            $customSystemMessage = 'Your name is Blackgpt, you will answer only Black Community related questions, give precise answers. You are a copilot. A black community expert with history, community and all. Keep this in mind. Do not answer anything outside of Black Community related topic. And do not talk about what and how many context you have. Just use them. \n\n{context}.';
    
            // Generate or retrieve a session ID
            $sessionId = $request->session()->get('chat_session_id', Str::uuid()->toString());
            $request->session()->put('chat_session_id', $sessionId);
    
            // Assuming you have an authenticated user
            $userId = auth()->id(); // Ensure this correctly identifies the current user
    
            // Retrieve recent conversation history for context
            $recentConversations = ConversationHistory::where('user_id', $userId)
                                    ->where('session_id', $sessionId)
                                    ->latest()
                                    ->take(6) // Adjust based on desired conversation history length
                                    ->get()
                                    ->reverse(); // Reverse to maintain chronological order
    
            // Build context from recent conversations
            $context = $recentConversations->reduce(function ($carry, $conversation) {
                return $carry . "User: " . $conversation->prompt . "\nAI: " . $conversation->response . "\n";
            }, "");
    
            // Append the current prompt to the context
            $fullPrompt = $context . "User: " . $request->input('message', '') . "\n";
    
            // Setup and make the AI query
            $qa = new QuestionAnswering($filesVectorStore, $embeddingGenerator, $chat);
            $qa->systemMessageTemplate = $customSystemMessage;
    
            // Include the full prompt (with context) in the AI query
            $message = new Message();
            $message->content = $fullPrompt; // Now includes context
            $message->role = ChatRole::User;
    
            $stream = $qa->answerQuestionFromChat([$message]);
    
            if ($stream instanceof StreamInterface) {
                $responseContent = $stream->getContents();
    
                // Store the conversation in the database
                ConversationHistory::create([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'prompt' => $request->input('message', ''), // The original prompt without context
                    'response' => $responseContent, // The AI's response
                ]);
    
                return response()->json(['chatResponse' => $responseContent]);
            } else {
                Log::error('Unexpected response type', ['responseType' => gettype($stream)]);
                return response()->json(['error' => 'Unexpected response type'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            Log::error('Error processing chat completion', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function startNewSession(Request $request)
    {
        $newSessionId = Str::uuid()->toString();
        $request->session()->put('chat_session_id', $newSessionId);
    
        // Returning session ID is optional since we're not reloading the page
        return response()->json([
            'success' => true,
            'message' => 'A new conversation session has been started.'
        ]);
    }

    public function fetchConversationHistory(Request $request)
    {
        $userId = Auth::id(); // Get the current authenticated user's ID
    
        // Fetch the latest conversation for each session for the user
        $conversations = DB::table('conversation_histories')
                            ->select('session_id', DB::raw('MIN(created_at) as created_at'))
                            ->where('user_id', $userId)
                            ->groupBy('session_id')
                            ->latest('created_at')
                            ->take(50) // Adjust the number as needed
                            ->get();
    
        // Fetch the first prompt for each of these sessions
        $sessionPrompts = [];
        foreach ($conversations as $conversation) {
            $firstPrompt = ConversationHistory::where('user_id', $userId)
                                ->where('session_id', $conversation->session_id)
                                ->orderBy('created_at', 'asc')
                                ->first(['prompt', 'created_at']);
    
            if ($firstPrompt) {
                $sessionPrompts[] = [
                    'prompt' => $firstPrompt->prompt,
                    'created_at' => $firstPrompt->created_at,
                    'session_id' => $conversation->session_id
                ];
            }
        }
    
        return response()->json(['conversations' => $sessionPrompts]);
    }
        
    public function fetchSessionConversations(Request $request, $sessionId)
    {
        try {
            $userId = Auth::id();
            $conversations = ConversationHistory::where('user_id', $userId)
                                    ->where('session_id', $sessionId)
                                    ->orderBy('created_at', 'asc')
                                    ->get(['prompt', 'response', 'created_at']);
    
            return response()->json($conversations);
        } catch (\Exception $e) {
            \Log::error("Error fetching session conversations: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching conversations'], 500);
        }
    }
    

    
}
