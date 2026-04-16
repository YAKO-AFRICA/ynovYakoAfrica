
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js')
        .then(function(registration) {
            console.log('Service Worker OK:', registration.scope);
        })
        .catch(function(error) {
            console.log('Erreur Service Worker:', error);
        });
}