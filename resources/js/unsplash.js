const stored = JSON.parse(localStorage.getItem('unsplash') ?? '{}')
const set = Object.keys(stored).length > 0
const expired = set && Date.now() - stored.requested_at > 60 * 1000
const author = document.getElementById("unsplash__author")

let res = {}

// If we are on the home page
if (author) {
    if (!set || (set && expired)) {
        res = await fetch(
            `https://api.unsplash.com/photos/random?orientation=landscape`,
            {
                method: 'GET',
                headers: {
                    Authorization: `Client-ID ${import.meta.env.VITE_UNSPLASH_ACCESS_KEY}`
                }
            }
        )

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
