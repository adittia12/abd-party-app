<script>
    // Tambahkan event listener untuk tombol "Delete"
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                Swal.fire({
                    title: 'Delete Confirmation',
                    text: 'Do you want to delete this skill?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi, kirimkan permintaan penghapusan
                        const form = document.createElement('form');
                        form.setAttribute('action',
                            "{{ route('workforece_skill.destroy', '') }}" + '/' + id
                        );
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
    $(document).on('click', '.skillUpdate', function() {
        var _this = $(this).parents('tr');

        // Mengisi input dengan data dari tabel
        $('#e_id_skill').val(_this.find('.id_skill').text());
        $('#e_skill').val(_this.find('.skill').text());
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
                url: '{{ route('workforece_skill.index') }}',
                type: 'GET',
                data: {
                    per_page: perPage,
                    q: searchQuery,
                    filteringMonth: filteringMonth,
                    filterDate: filterDate
                },
                success: function(data) {
                    $('#skillTableContainer').html($(data).find(
                            '#skillTableContainer')
                        .html());
                }
            });
        });
    });
</script>
