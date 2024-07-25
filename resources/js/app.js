import.meta.glob([
    '../fonts/**',
]);

const modal = document.querySelector('.modal__wrapper');
const form = document.querySelector('.search-form__wrapper');
const input = form.querySelector('input');

if (localStorage.getItem('redirect_list') === null) {
    fetch('/api/redirectlist', {
        method: 'GET'
    }).then(async res => {
        localStorage.setItem('redirect_list', JSON.stringify(await res.json()));
    })
}

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
