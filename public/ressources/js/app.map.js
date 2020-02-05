let $map = document.querySelector('#map')

class LeafletMap {

    constructor () {
        this.map = null;
    }

    async load(element) {
        return new Promise((resolve, reject) => {
            $script('https://unpkg.com/leaflet@1.6.0/dist/leaflet.js', () => {
                this.map = L.map(element).setView([51.505, -0.09], 13);
                L.tileLayer('//{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                }).addTo(this.map);
                resolve()
            })
        })
    }

    addMarker(lat, lng, text) {
        // L.marker([lat, lng])
        L.popup({
            autoClose: false,
            closeOnEscapeKey: false,
            closeOnClick: false,
            closeButton: false,
            className: 'marker',
            maxWidth: 800
        })
            .setLatLng([lat,lng])
            .setContent(text)
            .openOn(this.map)
    }
}

const initMap = async function() {
    let map = new LeafletMap();
    await map.load($map);
    Array.from(document.querySelectorAll('.js-marker')).forEach((item) => {
        console.log("un maker");
        map.addMarker(item.dataset.lat, item.dataset.lng, 'implementer mini carte');
        console.log("fini");
    })

};

if($map != null) {
    initMap()
}