<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ChatAccessCodeMail;
use App\Models\ChatEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ChatEmailController extends Controller
{
    public function index()
    {
        return view('admin.chat-emails.index');
    }

    public function data()
    {
        return DataTables::eloquent(ChatEmail::query()->latest('id'))
            ->addIndexColumn()
            ->editColumn('allow_chat', function (ChatEmail $chatEmail) {
                $class = $chatEmail->allow_chat ? 'badge-success' : 'badge-secondary';
                $label = $chatEmail->allow_chat ? 'Allowed' : 'Blocked';

                return '<span class="badge ' . $class . '">' . $label . '</span>';
            })
            ->editColumn('last_chat_at', function (ChatEmail $chatEmail) {
                return optional($chatEmail->last_chat_at)->format('Y-m-d H:i') ?: 'Never';
            })
            ->addColumn('actions', function (ChatEmail $chatEmail) {
                $editUrl = route('admin.chat-emails.edit', $chatEmail);
                $sendUrl = route('admin.chat-emails.send-code', $chatEmail);
                $deleteUrl = route('admin.chat-emails.destroy', $chatEmail);

                return '<span class="chat-email-actions">'
                    . '<a href="' . e($editUrl) . '" class="btn btn-info btn-sm chat-email-action" '
                    . 'title="Edit chat email" aria-label="Edit chat email">'
                    . '<i class="fa fa-pencil"></i></a>'
                    . '<form action="' . e($sendUrl) . '" method="POST" class="d-inline-block">'
                    . csrf_field()
                    . '<button type="submit" class="btn btn-primary btn-sm chat-email-action" '
                    . 'title="Send chat code email" aria-label="Send chat code email">'
                    . '<i class="fa fa-envelope"></i></button></form>'
                    . '<form action="' . e($deleteUrl) . '" method="POST" class="d-inline-block" '
                    . 'onsubmit="return confirm(\'Delete this chat email?\')">'
                    . csrf_field() . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm chat-email-action" '
                    . 'title="Delete chat email" aria-label="Delete chat email">'
                    . '<i class="fa fa-trash"></i></button></form></span>';
            })
            ->rawColumns(['allow_chat', 'actions'])
            ->toJson();
    }

    public function create()
    {
        return view('admin.chat-emails.create', [
            'chatEmail' => new ChatEmail(['allow_chat' => true]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['email'] = Str::lower(trim($data['email']));
        $data['chat_code'] = $data['chat_code'] ?: $this->newChatCode();
        $data['allow_chat'] = $request->boolean('allow_chat');

        ChatEmail::create($data);

        return redirect()->route('admin.chat-emails.index')
            ->with('success', 'Chat email added successfully.');
    }

    public function edit(ChatEmail $chatEmail)
    {
        return view('admin.chat-emails.edit', compact('chatEmail'));
    }

    public function update(Request $request, ChatEmail $chatEmail)
    {
        $data = $this->validated($request, $chatEmail);
        $data['email'] = Str::lower(trim($data['email']));
        $data['allow_chat'] = $request->boolean('allow_chat');

        if (empty($data['chat_code'])) {
            unset($data['chat_code']);
        }

        $chatEmail->update($data);

        return redirect()->route('admin.chat-emails.index')
            ->with('success', 'Chat email updated successfully.');
    }

    public function sendCode(ChatEmail $chatEmail)
    {
        try {
            Mail::to($chatEmail->email)->send(new ChatAccessCodeMail($chatEmail));
        } catch (\Throwable $exception) {
            report($exception);

            return back()->with('error', 'The chat code email could not be sent.');
        }

        return back()->with('success', 'Chat code email sent to ' . $chatEmail->email . '.');
    }

    public function destroy(ChatEmail $chatEmail)
    {
        $chatEmail->delete();

        return redirect()->route('admin.chat-emails.index')
            ->with('success', 'Chat email deleted successfully.');
    }

    private function validated(Request $request, ?ChatEmail $chatEmail = null): array
    {
        $id = $chatEmail ? ',' . $chatEmail->id : '';

        return $request->validate([
            'email' => ['required', 'email', 'max:150', 'unique:chat_emails,email' . $id],
            'chat_code' => ['nullable', 'string', 'max:64', 'unique:chat_emails,chat_code' . $id],
            'display_name' => ['nullable', 'string', 'max:100'],
            'allow_chat' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }

    private function newChatCode(): string
    {
        do {
            $code = Str::upper(Str::random(12));
        } while (ChatEmail::query()->where('chat_code', $code)->exists());

        return $code;
    }
}
