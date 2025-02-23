@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Unprocessed Messages</h1>

        @if($messages->count() > 0)
            <ul class="list-group mt-4">
                @foreach($messages as $message)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>ID:</strong> {{ $message['id'] }} <br>
                            <strong>Message:</strong> {{ $message['message'] }} <br>
                            <strong>Status:</strong> <span class="badge bg-warning">To be processed</span>
                        </div>
                        <form action="{{ route('complete.message') }}" method="POST" class="ml-2">
                            @csrf
                            <input type="hidden" name="messageId" value="{{ $message['id'] }}">
                            <button type="submit" class="btn btn-success">Process Message</button>
                        </form>
                    </li>
                    <hr>
                @endforeach
            </ul>
        @else
            <p class="text-center mt-4">No messages to process</p>
        @endif
    </div>

    <!-- Floating Refresh Button -->
    <button id="refreshButton" class="btn btn-primary position-fixed bottom-3 end-3" onclick="location.reload()">
        🔄 Refresh
    </button>

    <style>
        .fade-out {
            animation: fadeOut 1s forwards;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        #refreshButton {
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 50px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
    </style>

    <script>
        document.querySelectorAll('.btn-success').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('form');
                const listItem = this.closest('.list-group-item');

                listItem.classList.add('fade-out');

                listItem.addEventListener('animationend', () => {
                    form.submit();
                });
            });
        });
    </script>
@endsection