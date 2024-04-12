if (!('BarcodeDetector' in window)) {
    console.log('no BarcodeDetector support');
} else {
    const barcodeDetector = new BarcodeDetector({
        formats: ['aztec', 'code_128', 'code_39', 'code_93', 'codabar', 'data_matrix', 'ean_13', 'ean_8', 'itf', 'pdf417', 'qr_code', 'upc_a', 'upc_e'],
    });
    let interval = undefined;
    let found = false;
    const line = document.querySelector('.line');
    const videoPreview = document.querySelector('#video-preview');
    const searchInput = document.getElementById('searchInput');

    navigator.mediaDevices
        .getUserMedia({ video: true })
        .then(async (videoStream) => {
            videoPreview.srcObject = videoStream;
        });

    videoPreview.addEventListener('loadeddata', startScanning);

    function startScanning() {
        clearInterval(interval);
        interval = setInterval(scan, 500);
    }

    async function scan() {
        if (!found) {
            line.classList.add('animate');
            console.log('scanning...');
            const barcodes = await barcodeDetector.detect(videoPreview);
            if (barcodes.length > 0) {
                const scannedValue = barcodes[0].rawValue;
                console.log(scannedValue);
                searchInput.value = scannedValue; // Set the scanned value in the search input
                search(); // Automatically trigger search
                found = true;
            }
        } else {
            line.classList.remove('animate');
            clearInterval(interval);
        }
    }

    function search() {
        const inputValue = searchInput.value;
        console.log('Search for:', inputValue);

        // Hier AJAX hinzufügen, um die Datenbank nach ID zu durchsuchen
        // Beachten Sie, dass Sie die URL anpassen müssen, um auf Ihre PHP-Datei zu verweisen
        const searchUrl = `searchById.php?id=${encodeURIComponent(inputValue)}`;

        fetch(searchUrl)
            .then(response => response.json())
            .then(data => {
                // Hier können Sie die Daten weiterverarbeiten, z.B. in der Konsole ausgeben
                console.log('Search result:', data);

                // Hier können Sie die Daten in Ihrem HTML-Dokument anzeigen
                // Zum Beispiel können Sie ein HTML-Element erstellen und die Daten einfügen
                const resultContainer = document.getElementById('resultContainer');
                resultContainer.innerHTML = JSON.stringify(data, null, 2);
            })
            .catch(error => console.error('Error:', error));
    }

    function viewAllItems() {
        // Navigiere zur view_all_items.html-Seite
        window.location.href = 'list.html';
    }

    function addItem() {
        // Navigiere zur add_item.html-Seite
        window.location.href = 'add_item.html';
    }
}