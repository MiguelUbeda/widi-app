/**
 * Display and hide further details in the products listed
 * @param {number} position - The position identifier of the product
 */
function toggleDetails(position) {
    const detailsElement = document.getElementById(`details-${position}`);
    const button = document.querySelector(`[data-position="${position}"] .btn-toggle`);
    const toggleText = button.querySelector('.toggle-text');
    const chevron = button.querySelector('.chevron');

    if (detailsElement.classList.contains('show')) {
        detailsElement.classList.remove('show');
        toggleText.textContent = 'Mostrar más';
        chevron.textContent = '⌄';
        chevron.classList.remove('chevron-up');
        chevron.classList.add('chevron-down');
    } else {
        detailsElement.classList.add('show');
        toggleText.textContent = 'Mostrar menos';
        chevron.textContent = '⌃';
        chevron.classList.remove('chevron-down');
        chevron.classList.add('chevron-up');
    }
}