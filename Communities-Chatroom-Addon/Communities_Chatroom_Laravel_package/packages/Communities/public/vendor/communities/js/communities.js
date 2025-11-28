window.Communities = (function () {
    function ajax(url, method, data, onSuccess, onError) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const headers = { 'X-Requested-With': 'XMLHttpRequest' };
        if (!(data instanceof FormData)) {
            headers['Content-Type'] = 'application/json';
            data = data ? JSON.stringify(data) : null;
        }
        fetch(url, {
            method: method || 'GET',
            headers: headers,
            body: data,
            credentials: 'same-origin'
        }).then(async (resp) => {
            const payload = await resp.json().catch(() => ({}));
            if (!resp.ok) throw payload;
            onSuccess && onSuccess(payload);
        }).catch(err => {
            console.error(err);
            onError && onError(err);
            toast(err?.message || 'Action failed');
        });
    }

    function toast(message) {
        if (!message) return;
        alert(message);
    }

    function initFeed() {
        const feedForm = document.getElementById('feed-composer-form');
        if (feedForm) {
            feedForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const data = new FormData(feedForm);
                ajax(`/api/communities/${feedForm.dataset.communityId}/feed`, 'POST', data, () => location.reload());
            });
        }
        document.querySelectorAll('.feed-item .js-react').forEach(btn => {
            btn.addEventListener('click', function () {
                const feedId = this.closest('.feed-item').dataset.feedId;
                ajax(`/api/communities/feed/${feedId}/react`, 'POST', { reaction: this.dataset.reaction }, (payload) => {
                    this.querySelector('.count').innerText = payload.count ?? '1';
                });
            });
        });
        document.querySelectorAll('.feed-item .js-toggle-comments').forEach(btn => {
            btn.addEventListener('click', function () {
                const container = this.closest('.feed-item').querySelector('.feed-item__comments');
                container.classList.toggle('d-none');
            });
        });
        document.querySelectorAll('.feed-comment-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const data = Object.fromEntries(new FormData(form).entries());
                ajax(`/api/communities/feed/${form.dataset.feedId}/comment`, 'POST', data, () => location.reload());
            });
        });
    }

    function initChannel(channelId, options = {}) {
        const list = document.getElementById('channel-message-list');
        const form = document.getElementById('channel-message-form');
        const reactEndpoint = list?.dataset.react;

        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const data = new FormData(form);
                ajax(form.dataset.endpoint, 'POST', data, (payload) => {
                    appendMessage(list, payload.data);
                    form.reset();
                    scrollToBottom(list);
                });
            });
        }

        list?.addEventListener('click', function (e) {
            if (e.target.classList.contains('js-react')) {
                const messageEl = e.target.closest('.channel-message');
                const messageId = messageEl.dataset.messageId;
                ajax(reactEndpoint.replace('/0', `/${messageId}`), 'POST', { emoji: e.target.dataset.emoji }, () => {
                    e.target.classList.add('active');
                });
            }
        });

        if (window.Echo && options.broadcastPrefix) {
            window.Echo.private(`${options.broadcastPrefix}.channels.${channelId}`)
                .listen('ChannelMessagePosted', (event) => {
                    appendMessage(list, event.message);
                    scrollToBottom(list);
                });
        }
    }

    function appendMessage(container, message) {
        if (!container || !message) return;
        const wrapper = document.createElement('div');
        wrapper.className = 'channel-message';
        wrapper.dataset.messageId = message.id;
        wrapper.innerHTML = `
            <div class="channel-message__avatar"><img src="${message.user?.avatar || ''}" class="rounded-circle" width="36" height="36"></div>
            <div class="channel-message__body">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-semibold">${message.user?.name || 'User'}</span>
                    <span class="text-muted tiny">${message.created_at || ''}</span>
                </div>
                <div class="channel-message__content">${message.content || ''}</div>
            </div>`;
        container.appendChild(wrapper);
    }

    function scrollToBottom(container) {
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    function initDM(threadId, options = {}) {
        const form = document.getElementById('dm-message-form');
        const list = document.getElementById('dm-message-list');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const data = new FormData(form);
                ajax(form.dataset.endpoint, 'POST', data, (payload) => {
                    appendMessage(list, payload.data);
                    form.reset();
                    scrollToBottom(list);
                });
            });
        }
        if (window.Echo && options.broadcastPrefix) {
            window.Echo.private(`${options.broadcastPrefix}.dm.${threadId}`)
                .listen('DMMessagePosted', (event) => {
                    appendMessage(list, event.message);
                    scrollToBottom(list);
                });
        }
    }

    function initDMComposer() {
        const form = document.getElementById('dm-thread-form');
        if (!form) return;
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(form).entries());
            ajax(form.dataset.endpoint, 'POST', data, (payload) => {
                window.location.href = `/dm/${payload.data.id}`;
            });
        });
    }

    function initHeatmap() {
        const heatmap = document.getElementById('heatmap');
        if (!heatmap) return;
        ajax(heatmap.dataset.endpoint, 'GET', null, (payload) => {
            renderHeatmap(heatmap, payload.data || []);
        });
    }

    function renderHeatmap(container, data) {
        container.innerHTML = '';
        data.forEach((item) => {
            const cell = document.createElement('div');
            cell.className = 'cell';
            cell.style.backgroundColor = colorForValue(item.count || 0);
            cell.innerHTML = `<span>${item.count}</span>`;
            container.appendChild(cell);
        });
    }

    function colorForValue(val) {
        if (val > 20) return '#2563eb';
        if (val > 10) return '#60a5fa';
        if (val > 5) return '#93c5fd';
        if (val > 0) return '#dbeafe';
        return '#f1f5f9';
    }

    return {
        Feed: { init: initFeed },
        Chat: { initChannel },
        DM: { init: initDM, initComposer: initDMComposer },
        Heatmap: { init: initHeatmap }
    };
})();

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('channel-message-list')) {
        const channelId = document.querySelector('main.channel-main')?.dataset.channelId;
        window.Communities.Chat.initChannel(channelId || null, { broadcastPrefix: window.communitiesBroadcastPrefix || 'communities' });
    }
    if (document.getElementById('dm-message-list')) {
        const threadId = document.querySelector('main.channel-main')?.dataset.threadId;
        window.Communities.DM.init(threadId || null, { broadcastPrefix: window.communitiesBroadcastPrefix || 'communities' });
    }
    window.Communities.DM.initComposer();
    window.Communities.Feed.init();
    window.Communities.Heatmap.init();
});
