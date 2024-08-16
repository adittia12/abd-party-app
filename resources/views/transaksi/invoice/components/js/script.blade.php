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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const perPageValue = document.querySelector('select[name="per_page"]').value;

        document.querySelectorAll('form').forEach(form => {
            let perPageInput = form.querySelector('input[name="per_page"]');
            if (!perPageInput) {
                perPageInput = document.createElement('input');
                perPageInput.type = 'hidden';
                perPageInput.name = 'per_page';
                form.appendChild(perPageInput);
            }
            perPageInput.value = perPageValue;
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#perPageSelect').change(function() {
            var perPage = $(this).val();
            var searchQuery = $('#searchQuery').val();
            var filteringMonth = '{{ request('filteringMonth') }}';
            var filterDate = '{{ request('filterDate') }}';

            $.ajax({
                url: '{{ route('invoice.index') }}',
                type: 'GET',
                data: {
                    per_page: perPage,
                    q: searchQuery,
                    filteringMonth: filteringMonth,
                    filterDate: filterDate
                },
                success: function(data) {
                    $('#invoiceTableContainer').html($(data).find('#invoiceTableContainer')
                        .html());
                }
            });
        });
    });
</script>
