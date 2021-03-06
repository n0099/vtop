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
        if (/^\/(sysmsg|im|f)\//.test(url.pathname) || url.hostname === 'nsclick.baidu.com') {
            // silence requests from tracking service on nsclick.baidu.com and some tieba resource which using root relative path
            return new Response('', { status: 502 });
        }
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
