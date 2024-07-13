import.meta.glob([
    '../fonts/**',
]);

window.blacklist = async (website) => {
    await fetch('/api/blacklist', {
        method: 'POST',
        body: JSON.stringify({
            website
        }),
    })

    document.querySelectorAll(`[data-website="${website}"]`).forEach(e => e.remove())
}
