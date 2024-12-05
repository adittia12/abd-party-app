<script>
    // Tambahkan event listener untuk tombol "Delete"
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                Swal.fire({
                    title: 'Delete Confirmation',
                    text: 'Do you want to delete this group?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi, kirimkan permintaan penghapusan
                        const form = document.createElement('form');
                        form.setAttribute('action',
                            "{{ route('group.destroy', '') }}" + '/' + id);
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
    $(document).on('click', '.groupUpdate', function() {
        let _this = $(this).parents('tr');
        $('#e_code_id_group').val(_this.find('.code_id_group').text());
        $('#e_name_group').val(_this.find('.name_group').text());
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
            let perPage = $(this).val();
            let searchQuery = $('#searchQuery').val();
            let filteringMonth = '{{ request('filteringMonth') }}';
            let filterDate = '{{ request('filterDate') }}';

            $.ajax({
                url: '{{ route('group.index') }}',
                type: 'GET',
                data: {
                    per_page: perPage,
                    q: searchQuery,
                    filteringMonth: filteringMonth,
                    filterDate: filterDate
                },
                success: function(data) {
                    $('#groupTableContainer').html($(data).find('#groupTableContainer')
                        .html());
                }
            });
        });
    });
</script>
