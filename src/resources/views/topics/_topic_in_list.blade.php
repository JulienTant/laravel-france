<div class="post">
    <div class="row">
        <div class="d-none d-md-block col-md-2">
            <div class="m-auto avatar p-1">
                <img src="//www.gravatar.com/avatar/{{ md5($topic->user->email) }}?s=75" alt="{{ "Avatar de " . $topic->user->username }}" data-toggle="tooltip" data-placement="top" title="{{ $topic->user->username }}">
                {{ $topic->user->username }}
            </div>
        </div>
        <div class="col-12 col-md-7">
            <h3 class="topic-title {{ $topic->solved ? 'topic-title-solved' : '' }}"><a href="{{ route('topics.show', [$topic->forumsCategory->slug, $topic->slug]) }}">{{ $topic->title }}</a></h3>
            <p class="excerpt">{{ Str::limit($topic->firstMessage->markdown, 150) }}</p>
        </div>
        <div class="d-none d-md-block col-md-3">
            <div class="category">
                @include('topics._badge', ['category' => $topic->forumsCategory])
            </div>
            <div class="comments">
                <i class="fa fa-comment-o"></i> {{ $topic->nb_messages-1 }}
            </div>
            <div class="time">
                <i class="fa fa-clock-o"></i> {{ $topic->lastMessage->created_at->diffForHumans() }}
            </div>

        </div>
    </div>
</div>
