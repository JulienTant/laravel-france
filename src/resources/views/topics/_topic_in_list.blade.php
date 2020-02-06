<div class="post">
    <div class="row">
        <div class="d-none d-md-block col-md-2">
            <div class="m-auto avatar p-1">
                <img src="//www.gravatar.com/avatar/{{ md5($topic->user->email) }}?s=75" alt="{{ "Avatar de " . $topic->user->username }}" data-toggle="tooltip" data-placement="top" title="{{ $topic->user->username }}">
                <span class="small">{{ $topic->user->username }}</span>
            </div>

        </div>
        <div class="col-12 col-md-7">
            <h3 class="topic-title {{ $topic->solved ? 'topic-title-solved' : '' }}">
                <a href="{{ Auth::user() != null && Auth::user()->getForumsPreferencesItem('see_last_message') ? route('messages.show', [$topic->last_message_id]) : route('topics.show', [$topic->forumsCategory->slug, $topic->slug]) }}">
                    {{ $topic->title }}
                </a>
            </h3>
            <p class="excerpt">{{ Str::limit($topic->firstMessage->markdown, 150) }}</p>
        </div>
        <div class="d-none d-md-block col-md-3">
            <div class="category">
                @include('topics._badge', ['category' => $topic->forumsCategory])
            </div>
            <div class="comments">
                <i class="fa fa-comment-o"></i> <span class="small">{{ $topic->nb_messages > 1 ? $topic->nb_messages-1 : "Aucune réponse" }}</span>
            </div>
            <div class="time">
                @if($topic->nb_messages>1)
                <i class="fa fa-clock-o"></i> <span class="small">{{ $topic->lastMessage->created_at->diffForHumans() }} par {{ $topic->lastMessage->user->username }}</span>
                @endif
            </div>

        </div>
    </div>
</div>
