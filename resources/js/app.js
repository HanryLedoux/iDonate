import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Donation AJAX handlers
document.addEventListener('DOMContentLoaded', function () {
	// AJAX submit for donation forms (company page)
	document.querySelectorAll('form.donation-form').forEach(function (form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			const data = new FormData(form);
			const action = form.action;
			const token = document.querySelector('meta[name="csrf-token"]').content;

			fetch(action, {
				method: 'POST',
				headers: { 'X-CSRF-TOKEN': token },
				body: data,
				credentials: 'same-origin'
			}).then(r => r.redirected ? window.location.href = r.url : r.text())
			.then(resp => {
				// if response text contains success message, reload
				if (typeof resp === 'string' && resp.includes('Solicitação de doação enviada')) {
					window.location.href = '/donations';
				}
			}).catch(() => {
				window.location.reload();
			});
		});
	});

	// AJAX cancel buttons on donations list

	// Modal-based cancel flow to avoid blocking native confirm dialogs
	const cancelModal = document.getElementById('cancel-modal');
	const cancelModalClose = document.getElementById('cancel-modal-close');
	const cancelModalConfirm = document.getElementById('cancel-modal-confirm');
	let pendingDonationId = null;

	const cancelModalQty = document.getElementById('cancel-modal-qty');
	const cancelModalMax = document.getElementById('cancel-modal-max');

	document.querySelectorAll('button.cancel-donation').forEach(function (btn) {
		btn.addEventListener('click', function (e) {
			e.preventDefault();
			pendingDonationId = btn.dataset.donationId;
			const max = parseInt(btn.dataset.donationQty || '1', 10);
			if (cancelModalQty) {
				cancelModalQty.max = max;
				cancelModalQty.value = Math.min(1, max);
			}
			if (cancelModalMax) cancelModalMax.textContent = String(max);
			// store a reference to the clicked button so we can remove the correct card later
			cancelModal.dataset.triggerButtonIndex = Array.from(document.querySelectorAll('button.cancel-donation')).indexOf(btn);
			if (cancelModal) cancelModal.classList.remove('hidden', 'opacity-0');
		});
	});

	if (cancelModalClose) {
		cancelModalClose.addEventListener('click', function () {
			if (cancelModal) cancelModal.classList.add('hidden');
			pendingDonationId = null;
		});
	}

	if (cancelModalConfirm) {
		cancelModalConfirm.addEventListener('click', function () {
			if (!pendingDonationId) return;
			const donationId = pendingDonationId;
			const token = document.querySelector('meta[name="csrf-token"]').content;
			const qty = cancelModalQty ? parseInt(cancelModalQty.value || '1', 10) : 1;
			if (!qty || qty < 1) return alert('Quantidade inválida.');
			const max = cancelModalQty ? parseInt(cancelModalQty.max || String(qty), 10) : qty;
			if (qty > max) return alert('Quantidade maior que o disponível.');

			fetch(`/donations/${donationId}/partial-cancel`, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
				credentials: 'same-origin',
				body: JSON.stringify({ quantity: qty })
			}).then(res => res.json())
			.then(json => {
				if (json.success) {
					// update the card quantity or remove it if zero
					const selector = `button[data-donation-id="${donationId}"]`;
					const btn = document.querySelector(selector);
					const card = btn ? btn.closest('.donation-card') : null;
					if (!card) {
						if (cancelModal) cancelModal.classList.add('hidden');
						pendingDonationId = null;
						return;
					}
					const qtyElem = card.querySelector('.donation-quantity');
					if (json.remaining_quantity <= 0) {
						card.remove();
					} else if (qtyElem) {
						qtyElem.textContent = String(json.remaining_quantity);
						// also update button data attribute
						const btnInside = card.querySelector('button.cancel-donation');
						if (btnInside) btnInside.dataset.donationQty = String(json.remaining_quantity);
					}
					if (cancelModal) cancelModal.classList.add('hidden');
					pendingDonationId = null;
				} else {
					alert(json.error || 'Erro ao cancelar pedido.');
				}
			}).catch(() => alert('Erro ao cancelar pedido.'));
		});
	}
});
