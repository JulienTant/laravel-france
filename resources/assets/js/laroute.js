(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://homestead.app',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/open","name":"debugbar.openhandler","action":"Barryvdh\Debugbar\Controllers\OpenHandlerController@handle"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/clockwork\/{id}","name":"debugbar.clockwork","action":"Barryvdh\Debugbar\Controllers\OpenHandlerController@clockwork"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/assets\/stylesheets","name":"debugbar.assets.css","action":"Barryvdh\Debugbar\Controllers\AssetController@css"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/assets\/javascript","name":"debugbar.assets.js","action":"Barryvdh\Debugbar\Controllers\AssetController@js"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"\/","name":"forums.index","action":"ForumsController@topics"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"c\/{slug}","name":"forums.by-category","action":"ForumsController@topics"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"search","name":"forums.search","action":"ForumsController@search"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"t\/{categorySlug}\/{topicSlug}","name":"forums.show-topic","action":"ForumsController@topic"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"m\/{messageId}","name":"forums.show-message","action":"ForumsController@message"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"sujets-suivis","name":"my-forums.watched-topics","action":"MyForumController@watchedTopics"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"mes-sujets","name":"my-forums.my-topics","action":"MyForumController@myTopics"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"mes-messages","name":"my-forums.my-messages","action":"MyForumController@myMessages"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"socialite\/{driver}","name":"socialite.login","action":"SocialiteController@redirectToProvider"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"socialite\/{driver}\/callback","name":"socialite.callback","action":"SocialiteController@handleProviderCallback"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"logout","name":"logout","action":"SocialiteController@logout"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"slack","name":"slack","action":"StaticController@slack"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"contact","name":"contact","action":"ContactController@index"},{"host":"homestead.app","methods":["POST"],"uri":"contact","name":"contact.send","action":"ContactController@send"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"contact\/sent","name":"contact.sent","action":"ContactController@sent"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"profile","name":"profile","action":"ProfileController@index"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"profile\/change-username","name":"profile.change-username","action":"ProfileController@changeUsername"},{"host":"homestead.app","methods":["POST"],"uri":"profile\/change-username","name":"profile.change-username.post","action":"ProfileController@postChangeUsername"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"profile\/change-avatar","name":"profile.change-avatar","action":"ProfileController@changeAvatar"},{"host":"homestead.app","methods":["POST"],"uri":"profile\/change-avatar","name":"profile.change-avatar.post","action":"ProfileController@postChangeAvatar"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"profile\/forums","name":"profile.forums","action":"ProfileController@forums"},{"host":"homestead.app","methods":["POST"],"uri":"profile\/forums","name":"profile.forums.post","action":"ProfileController@postForums"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"admin\/users","name":"admin.users.index","action":"Admin\UserControler@index"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"admin\/users\/{user}\/groups","name":"admin.users.groups","action":"Admin\UserControler@groups"},{"host":"homestead.app","methods":["POST"],"uri":"admin\/users\/{user}\/groups","name":"admin.users.save-groups","action":"Admin\UserControler@saveGroups"},{"host":"homestead.app","methods":["POST"],"uri":"api\/renderMarkdown","name":"api.markdown","action":"Api\MarkdownController@render"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"api\/forums\/{topicId}\/watch","name":"api.forums.watch","action":"Api\ForumsController@watch"},{"host":"homestead.app","methods":["POST"],"uri":"api\/forums\/{topicId}\/toggle-watch","name":"api.forums.toggle-watch","action":"Api\ForumsController@toggleWatch"},{"host":"homestead.app","methods":["POST"],"uri":"api\/forums\/post","name":"api.forums.post","action":"Api\ForumsController@post"},{"host":"homestead.app","methods":["POST"],"uri":"api\/forums\/{topicId}\/reply","name":"api.forums.reply","action":"Api\ForumsController@reply"},{"host":"homestead.app","methods":["GET","HEAD"],"uri":"api\/forums\/{topicId}\/messages\/{messageId}","name":"api.forums.message","action":"Api\ForumsController@message"},{"host":"homestead.app","methods":["PUT"],"uri":"api\/forums\/{topicId}\/messages\/{messageId}","name":"api.forums.message.update","action":"Api\ForumsController@updateMessage"},{"host":"homestead.app","methods":["DELETE"],"uri":"api\/forums\/{topicId}\/messages\/{messageId}","name":"api.forums.message.delete","action":"Api\ForumsController@deleteMessage"},{"host":"homestead.app","methods":["POST"],"uri":"api\/forums\/{topicId}\/messages\/{messageId}\/solve_topic","name":"api.forums.message.solved_topic","action":"Api\ForumsController@solveTopic"},{"host":"forums.homestead.app","methods":["GET","HEAD"],"uri":"\/","name":null,"action":"Closure"},{"host":"forums.homestead.app","methods":["GET","HEAD"],"uri":"{old_slug}-c{old_categoryId}","name":null,"action":"Closure"},{"host":"forums.homestead.app","methods":["GET","HEAD"],"uri":"{old_slug}-t{old_topicId}","name":null,"action":"Closure"}],

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                return this.getCorrectUrl(uri + qs);
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = '/' + uri.replace(/^\/?/, '');

                if(!this.absolute)
                    return url;

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class via CommonJSt
     */
    module.exports = laroute;

}).call(this);

