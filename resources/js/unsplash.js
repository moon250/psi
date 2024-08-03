const stored = JSON.parse(localStorage.getItem('unsplash') ?? '{}')
const set = Object.keys(stored).length > 0
const expired = set && Date.now() - stored.requested_at > 3000

let res = {}

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

console.log(res)
document.body.style.setProperty('--unsplash-image', `url(${res.urls.regular})`)
