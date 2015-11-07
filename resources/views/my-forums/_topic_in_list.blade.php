<?php
    $topic = $watchedTopic->forumsTopic;
?>
<li class="Forums__TopicList__Item">
    @if($watchedTopic->first_unread_message_id)
        <a href="{{ route('forums.show-message', [$watchedTopic->first_unread_message_id]) }}" class="Forums__TopicList__Item__Link">
    @else
            <a href="{{ topic_link_for_listing($topic) }}" class="Forums__TopicList__Item__Link">
    @endif
        <div class="Forums__TopicList__Item__Avatar">
            <img src="//www.gravatar.com/avatar/{{ md5($topic->user->email) }}?s=68" alt="Avatar de {{ $topic->user->username }}">
        </div>

        <div class="Forums__TopicList__Item__Content">
            <h3 class="Forums__TopicList__Item__Subject {{ $topic->solved ? 'Forums__TopicList__Item__Subject--Solved' : '' }}">{{ $topic->title }}</h3>
            <span class="Forums__CategoryLabel" style="background-color: {{ $topic->forumsCategory->background_color }}; color: {{ $topic->forumsCategory->font_color }}">{{ $topic->forumsCategory->name }}</span>
                        <span class="Forums__TopicList__Item__Metas__Authoring">
                            Par <strong>{{ $topic->user->username }}</strong>
                            @if($topic->nb_messages > 1)
                                , dernier message : <strong>{{ $topic->lastMessage->user->username }}</strong>
                            @endif
                            <relative-date date="{{ $topic->lastMessage->created_at->format('Y-m-d H:i:s') }}"></relative-date>
                        </span>
            <p class="Forums__TopicList__Item__Excerpt">
                {{ str_limit($topic->firstMessage->markdown, 150) }}
            </p>
        </div>

        <div class="Forums__TopicList__Item__NbReplies">
            <p class="Forums__TopicList__Item__NbReplies__Count">
                {{ $topic->nb_messages }}
            </p>
        </div>
    </a>
</li>