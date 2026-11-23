<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0">{{ $heading }}</h3>
                <a href="{{ route('admin.chat-emails.index') }}" class="btn btn-secondary btn-sm">Back to Chat Emails</a>
            </div>
            <div class="card-body">
                <form action="{{ $formAction }}" method="POST">
                    @csrf
                    @if ($formMethod !== 'POST')
                        @method($formMethod)
                    @endif

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $chatEmail->email) }}"
                                class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="display_name">Display Name</label>
                            <input type="text" id="display_name" name="display_name"
                                value="{{ old('display_name', $chatEmail->display_name) }}"
                                class="form-control @error('display_name') is-invalid @enderror">
                            @error('display_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="chat_code">Chat Code</label>
                            <div class="input-group">
                                <input type="text" id="chat_code" name="chat_code"
                                    value="{{ old('chat_code', $chatEmail->chat_code) }}"
                                    class="form-control @error('chat_code') is-invalid @enderror">
                                <div class="input-group-append">
                                    <button type="button" id="generate-chat-code" class="btn btn-outline-primary"
                                        title="Generate chat code" aria-label="Generate chat code">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">Leave blank on a new record to generate one automatically.</small>
                            @error('chat_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group col-md-6 d-flex align-items-center pt-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" id="allow_chat" name="allow_chat" value="1"
                                    class="custom-control-input"
                                    {{ old('allow_chat', $chatEmail->allow_chat) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="allow_chat">Allow this email to start chat</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea id="notes" name="notes" rows="4"
                            class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $chatEmail->notes) }}</textarea>
                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">{{ $submitLabel }}</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        var generateButton = document.getElementById('generate-chat-code');
        var codeInput = document.getElementById('chat_code');

        if (!generateButton || !codeInput) return;

        generateButton.addEventListener('click', function () {
            var alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            var code = '';

            for (var index = 0; index < 12; index++) {
                code += alphabet.charAt(Math.floor(Math.random() * alphabet.length));
            }

            codeInput.value = code;
        });
    })();
</script>
