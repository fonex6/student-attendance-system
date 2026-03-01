const CACHE_NAME = 'attendance-cache-v1';
const urlsToCache = [
    './index.php',
    './student_register_process.php',
    './lecturer/admin_login.php',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'
];

// Install Service Worker & cache resources
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            console.log('App shell cached');
            return cache.addAll(urlsToCache);
        })
    );
});

// Activate Service Worker
self.addEventListener('activate', event => {
    console.log('Service Worker Activated');
});

// Fetch requests
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request).then(response => response || fetch(event.request))
    );
});