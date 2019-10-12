    <a name="message-{{$message->id}}" id="message-{{$message->id}}"></a>
    <div class="message {{ $message->solve_topic ? 'message-solvetopic': '' }}">
        <div class="row">
            <div class="d-none d-md-block col-md-2">
                <div class="m-auto avatar p-1">
                    <div>
                    <img src="//www.gravatar.com/avatar/{{ md5($message->user->email) }}?s=75"
                         alt="{{ "Avatar de " . $message->user->username }}" data-toggle="tooltip" data-placement="top"
                         title="{{ $message->user->username }}">
                    </div>
                    <div>{{ $message->user->username }}</div>
                </div>
            </div>
            <div class="col-12 col-md-10 message-content">
                @markdown($message->markdown)
            </div>
        </div>
        <div class="row meta">
            <div class="offset-2 col-10 meta-content">
                <div class="row">
                    <div class="col-auto">
                        <i class="fa fa-clock-o"></i> Posté <a href="#message-{{$message->id}}">{{ $message->created_at->diffForHumans() }}</a>
                    </div>
                    @unless(isset($noButton) && $noButton == true)
                    <div class="col-auto ml-auto">
                        <div class="pr-2">
                        @can('forums.can_edit_message', $message)
                            <a href="{{ route('messages.edit', [$category->slug, $topic->slug, $message->id]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                                Editer
                            </a>
                        @endcan

                        @can('forums.can_remove_message', $message)
                            <a href="{{ route('messages.remove', [$category->slug, $topic->slug, $message->id, 'from' => URL::full() . '#message-'.$message->id]) }}" class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-trash"></i>
                                Supprimer
                            </a>
                        @endcan

                        @can('forums.can_mark_as_solve', $message)
                            <form method="POST" class="d-inline" action="{{ route('topics.solve', [$category->slug, $topic->slug]) }}">
                                @csrf
                                <input type="hidden" name="message_id" value="{{ $message->id }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fa fa-check"></i>
                                    Ce message répond à ma question
                                </button>
                            </form>
                        @endcan

                        {{--@can('forums.can_reply_to_topic', $message->forumstopic)--}}
                        {{--<button class="Button Button--Small" data-quote-username="{{ json_encode($message->user->username) }}" data-quote-message="{{ json_encode($message->markdown) }}" @click="citeMe">Citer</button>--}}
                        {{--@endcan--}}
                        </div>
                    </div>
                    @endunless
                </div>
            </div>
        </div>
    </div>

@php
    /*
    <li class="Forums__MessageList__Message {{ $message->solve_topic ? 'Forums__MessageList__Message--SolveTopic': '' }}">

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
    */
@endphp
