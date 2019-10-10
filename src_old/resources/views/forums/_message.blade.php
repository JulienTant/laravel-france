<li class="Forums__MessageList__Message {{ $message->solve_topic ? 'Forums__MessageList__Message--SolveTopic': '' }}">

    <div class="Forums__MessageList__Message__Side">
        <div class="Forums__MessageList__Message__Side__Avatar">
            <img src="//www.gravatar.com/avatar/{{ md5($message->user->email) }}?s=75" alt="Avatar de {{ $message->user->username }}">
        </div>

        <div class="Forums__MessageList__Message__Side__UserInfos">
            <dl>
                <dt class="Forums__MessageList__Message__Side__UserInfos__Label">Membre depuis :</dt>
                <dd class="Forums__MessageList__Message__Side__UserInfos__Info">{{ $message->user->created_at->format('d/m/Y') }}</dd>
                <dt class="Forums__MessageList__Message__Side__UserInfos__Label">Messages :</dt>
                <dd class="Forums__MessageList__Message__Side__UserInfos__Info">{{ $message->user->nb_messages }}</dd>
            </dl>
        </div>
    </div>

    <div class="Forums__MessageList__Message__Content">
        <span class="Forums__MessageList_Message__Content__Authoring">
            <span class="Forums__MessageList_Message__Content__Authoring--Author">{{ $message->user->username }}</span>
            <a href="#message-{{$message->id}}" name="message-{{$message->id}}" id="message-{{$message->id}}"><relative-date date="{{ $message->created_at->format('Y-m-d H:i:s') }}" /></a>
        </span>


        <div class="Forums__MessageList__Message__Content__Html">
            @markdown($message->markdown)
        </div>

        <div class="Forums_MessageList__Message__Content__Buttons">
            @can('forums.can_edit_message', $message)
                <edit-message message-id="{{ $message->id }}" topic-id="{{ $message->forums_topic_id }}">Editer</edit-message>
            @endcan

            @can('forums.can_remove_message', $message)

                <remove-message message-id="{{ $message->id }}" topic-id="{{ $message->forums_topic_id }}">Supprimer</remove-message>
            @endcan

            @can('forums.can_mark_as_solve', $message)
                <mark-topic-solved message-id="{{ $message->id }}" topic-id="{{ $message->forums_topic_id }}">Ce message répond à ma question</mark-topic-solved>
            @endcan

            {{--@can('forums.can_reply_to_topic', $message->forumstopic)--}}
                {{--<button class="Button Button--Small" data-quote-username="{{ json_encode($message->user->username) }}" data-quote-message="{{ json_encode($message->markdown) }}" @click="citeMe">Citer</button>--}}
            {{--@endcan--}}
        </div>
    </div>

</li>