self.addEventListener('activate', event => {
    event.waitUntil(clients.claim());
});

self.addEventListener('fetch', event => {
    // also in appealApi.php
    const allowedApiEndpoints = [
        'postappeal/detailAppeal',
        'postappeal/listAppeal',
        'postappeal/next',
        'appeal/detail',
        'appeal/list',
        'appeal/next',
        'appeal/tpl'
    ];
    event.respondWith((() => {
        const req = event.request;
        const url = new URL(req.url);
        const requestingApi = allowedApiEndpoints.filter(i => url.pathname.startsWith('/bawu2/' + i))[0] || null;
        if (requestingApi !== null) {
            return fetch(`./appealApi.php?url=${requestingApi}&${url.search.substr(1)}`);
        } else if (url.host === 'tb.himg.baidu.com') {
            url.host = 'himg.baidu.com';
            return Response.redirect(url.toString(), 302);
        } else {
            return fetch(req);
        }
    })());
});
