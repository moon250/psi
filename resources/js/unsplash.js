const stored = JSON.parse(localStorage.getItem('unsplash') ?? '{}')
const set = Object.keys(stored).length > 0
const expired = set && Date.now() - stored.requested_at > 60 * 1000
const author = document.getElementById("unsplash__author")
const indicator = document.querySelector(".home-page__search")

const collections = [
    '9887946', // Space
    '1065976', // Wallpapers
    '46022299', // Oceans
    'rnSKDHwwYUk', // Architecture
    '1155333', // Nature
    'xHxYTMHLgOc', // Street photography
    'Fzo3zuOHN6w', // Travels
    'Jpg6Kidl-Hk', // Animals
    'bDo48cUhwnY', // Arts & culture
    'dijpbw99kQQ', // History,
]

let res = {}

const randint = (min, max) => {
    return Math.floor(Math.random() * (max - min)) + min
}

// If we are on the home page
if (author) {
    if (!set || expired) {
        const collection = collections[randint(0, collections.length)]
        res = await fetch(
            `https://api.unsplash.com/photos/random?collections=${collection}?orientation=landscape`,
            {
                method: 'GET',
                headers: {
                    Authorization: `Client-ID ${import.meta.env.VITE_UNSPLASH_ACCESS_KEY}`
                }
            }
        ).catch(() => indicator.dataset.enabled = true)

        res = await res.json()

        localStorage.setItem('unsplash', JSON.stringify({
            requested_at: Date.now(),
            response: res
        }))
    } else {
        res = stored.response
    }

    document.body.style.setProperty('--unsplash-image', `url(${res.urls.regular})`)
    author.innerText = res.user.name
    author.href = res.user.links.html
}


window.reloadUnsplash = () => {
    localStorage.removeItem('unsplash')
    location.reload()
}
