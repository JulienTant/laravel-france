<li class="Forums__MyMessages__Message">
    <a href="{{ route('forums.show-message', [$message->id]) }}" class="Forums__MyMessages__Message__Link">
        <h3 class="Forums__MyMessages__Message__Subject">
            <span class="Forums__CategoryLabel" style="background-color: {{ $message->forumsTopic->forumsCategory->background_color }}; color: {{ $message->forumsTopic->forumsCategory->font_color }}">{{ $message->forumsTopic->forumsCategory->name }}</span>
            {{ $message->forumsTopic->title }}
        </h3>
    </a>
    <span class="Forums__MyMessages__Message__Meta">
       <relative-date date="{{ $message->created_at->format('Y-m-d H:i:s') }}"></relative-date>
    </span>
    <div class="Forums__MyMessages__Message__Content">
        @markdown($message->markdown)
    </div>
</li>