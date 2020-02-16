let $map = document.querySelector('#map')

class LeafletMap {

    constructor () {
        this.map = null;
    }

    async load(element) {
        return new Promise((resolve, reject) => {
            $script('https://unpkg.com/leaflet@1.6.0/dist/leaflet.js', () => {
                this.map = L.map(element).setView([46.4983, 2.6367], 5    );
                L.tileLayer('//{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                }).addTo(this.map);
                resolve()
            })
        })
    }

    addMarker(lat, lng, item) {
        L.marker([lat, lng]).addTo(this.map)
            .bindPopup(item);
        // L.popup({
        //     autoClose: false,
        //     closeOnEscapeKey: false,
        //     closeOnClick: false,
        //     closeButton: false,
        //     className: 'marker',
        //     maxWidth: 800
        // })
        //     .setLatLng([lat,lng])
        //     .setContent(text)
        //     .openOn(this.map)
    }
}

const initMap = async function() {
    let map = new LeafletMap();
    await map.load($map);
    Array.from(document.querySelectorAll('.js-marker')).forEach((item) => {

        //On clone la carte du stage associé
        let cln = item.cloneNode(true);

        //Récupération du tire du stage uniquement
        let notes = cln.childNodes[1];
        cln.innerHTML = notes.textContent;
        // cln.appendChild(notes.textContent);

        cln.style.fontSize = "15px";

        //Création du marker avec le titre du stage en note
        map.addMarker(item.dataset.lat, item.dataset.lng, cln );
    })

};

if($map != null) {
    initMap()
}