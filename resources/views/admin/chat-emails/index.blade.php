@extends('newLayout.layouts.newLayout')

@section('title', 'Chat Emails')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="card-title mb-1">Chat Emails</h3>
                        <p class="text-muted mb-0">Only allowed emails can start a support chat.</p>
                    </div>
                    <a href="{{ route('admin.chat-emails.create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add Chat Email
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="chat-emails-table" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Email</th>
                                    <th>Display Name</th>
                                    <th>Chat Code</th>
                                    <th>Allow Chat</th>
                                    <th>Last Chat</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        #chat-emails-table td,
        #chat-emails-table th { vertical-align: middle; }
        #chat-emails-table .badge { font-size: 12px; }
        #chat-emails-table .chat-email-actions {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        #chat-emails-table .chat-email-action {
            width: 30px;
            height: 30px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <script>
        window.addEventListener('load', function () {
            $('#chat-emails-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: @json(route('admin.chat-emails.data')),
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'email', name: 'email' },
                    { data: 'display_name', name: 'display_name', defaultContent: '' },
                    { data: 'chat_code', name: 'chat_code' },
                    { data: 'allow_chat', name: 'allow_chat', orderable: false },
                    { data: 'last_chat_at', name: 'last_chat_at' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']]
            });
        });
    </script>
@endsection
