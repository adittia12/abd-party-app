<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#createPo').on('show.bs.modal', function(event) { // Perbaiki event name ke 'show.bs.modal'
            var button = $(event.relatedTarget); // Gunakan var bukan let
            var invoiceId = button.data('invoice-id'); // Gunakan .data() bukan .getAttribute()
            $('#invoice_id').val(invoiceId);
        });
    });

    $(document).on('click', '.invoiceUpdate', function() {
        var _this = $(this).closest('tr');
        // $('#e_id_invoice').val($(this).data('id'));
        $('#e_invoice_number').val(_this.find('.invoice_number').text());
        $('#e_no_po_manual').val(_this.find('.no_po_manual').text().trim());
        $('#e_period_date').val(_this.find('.period_date').text().trim());
    });

    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                Swal.fire({
                    title: 'Delete Confirmation',
                    text: 'Do you want to delete this invoice?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi, kirimkan permintaan penghapusan
                        const form = document.createElement('form');
                        form.setAttribute('action',
                            "{{ route('invoice.destroy', '') }}" + '/' + id);
                        form.setAttribute('method', 'POST');
                        form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
