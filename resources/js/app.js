import.meta.glob([
    '../fonts/**',
]);

import "./unsplash.js"

const modal = document.querySelector('.modal__wrapper');
const form = document.querySelector('.search-form__wrapper');
const bangDiv = document.querySelector('.search-form__bangs');
const input = form.querySelector('input');

if (localStorage.getItem('redirect_list') === null) {
    fetch('/api/redirectlist', {
        method: 'GET'
    }).then(async res => {
        localStorage.setItem('redirect_list', JSON.stringify(await res.json()));
    })
}

if (
    localStorage.getItem('bang_list') === null ||
    new Date(localStorage.getItem('bang_list_updated-at')).getTime() < new Date().getTime() + 60_000
) {
    fetch('/api/bangs', {
        method: 'GET'
    }).then(async res => {
        localStorage.setItem('bang_list', JSON.stringify(await res.json()));
        localStorage.setItem('bang_list_updated-at', Date.now().toString())
    })
}

const bangList = JSON.parse(localStorage.getItem('bang_list'));

window.blacklist = async (website) => {
    await fetch('/api/blacklist', {
        method: 'POST',
        body: JSON.stringify({
            website
        }),
    })

    document.querySelectorAll(`[data-website="${website}"]`).forEach(e => e.remove())
}

window.modal = {
    yes: async () => {
        localStorage.setItem(
            'redirect_list',
            JSON.stringify(
                [
                    ...JSON.parse(localStorage.getItem('redirect_list') ?? '[]'),
                    input.value
                ]
            )
        )
        await fetch('/api/redirectlist', {
            method: 'POST',
            body: JSON.stringify({
                website: input.value
            }),
        })

        window.modal.no()
    },
    no: () => {
        modal.close()
        window.location.replace(encodeURI(`${location.origin}/search?q=${input.value}`));
    }
}

form.addEventListener('submit', e => {
    const query = input.value
    const storedRedirects = JSON.parse(localStorage.getItem('redirect_list') ?? '[]')

    if (query.match(/(\w+)(\.\w+)+/) && !storedRedirects.includes(query)) {
        e.preventDefault()
        modal.showModal()
    }
})

form.addEventListener('input', e => {
    let query = e.target.value.split('!')
    bangDiv.replaceChildren()
    form.dataset.show = "false"

    if (query.length < 2) return
    query = query[1]
    if (query.length < 1) return

    let found = Object.keys(bangList).filter(bang => bang.includes(query))

    // Only keep 4 results to avoid taking too much space
    found = found.slice(0, 4)

    for (const bang of found) {
        form.dataset.show = "true"
        const data = bangList[bang]
        const link = document.createElement('a')
        link.classList.add('text')
        link.id = bang
        link.href = encodeURI(`/search?q=${e.target.value.split('!')[0]}  ${bang}`)
        const favicon = document.createElement('img')
        favicon.src = `https://icons.duckduckgo.com/ip2/${data.url.split('/')[2].replace('www.', '')}.ico`
        link.appendChild(favicon)
        const name = document.createElement('p')
        name.textContent = `${bang} - ${data['name']}`
        link.appendChild(name)
        bangDiv.appendChild(link)
    }
})

