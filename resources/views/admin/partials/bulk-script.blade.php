{{-- BULK CONFIRM MODAL --}}

<div
    class="modal fade"
    id="bulkConfirmModal"
    tabindex="-1">

    <div
        class="
            modal-dialog
            modal-dialog-centered
        ">

        <div
            class="
                modal-content
                border-0
                shadow
            "
            style="border-radius:18px;">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Konfirmasi Aksi
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <p
                    id="bulkConfirmText"
                    class="mb-0">
                </p>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Batal

                </button>

                <button
                    type="button"
                    id="bulkConfirmButton"
                    class="btn btn-admin-primary">

                    Ya, Lanjutkan

                </button>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const selectAll =
            document.getElementById(
                'selectAll'
            );

        const checkboxes =
            document.querySelectorAll(
                '.row-checkbox'
            );

        const selectedCount =
            document.getElementById(
                'selectedCount'
            );

        const bulkAction =
            document.getElementById(
                'bulkAction'
            );

        const bulkActionButton =
            document.getElementById(
                'bulkActionButton'
            );

        const bulkConfirmButton =
            document.getElementById(
                'bulkConfirmButton'
            );

        const bulkConfirmText =
            document.getElementById(
                'bulkConfirmText'
            );

        const bulkForm =
            document.getElementById(
                'bulkForm'
            );


        function updateSelectedCount() {

            const checked =
                document.querySelectorAll(
                    '.row-checkbox:checked'
                );


            selectedCount.textContent =
                checked.length;


            if (
                selectAll &&
                checkboxes.length > 0
            ) {

                selectAll.checked =
                    checked.length
                    === checkboxes.length;

                selectAll.indeterminate =
                    checked.length > 0 &&
                    checked.length
                    < checkboxes.length;
            }
        }


        if (selectAll) {

            selectAll.addEventListener(
                'change',
                function () {

                    checkboxes.forEach(
                        checkbox => {

                            checkbox.checked =
                                selectAll.checked;
                        }
                    );

                    updateSelectedCount();
                }
            );
        }


        checkboxes.forEach(
            checkbox => {

                checkbox.addEventListener(
                    'change',
                    updateSelectedCount
                );
            }
        );


        bulkActionButton.addEventListener(
            'click',
            function () {

                const checked =
                    document.querySelectorAll(
                        '.row-checkbox:checked'
                    );


                if (
                    checked.length === 0
                ) {

                    alert(
                        'Pilih minimal satu {{ $itemLabel }}.'
                    );

                    return;
                }


                if (!bulkAction.value) {

                    alert(
                        'Pilih aksi terlebih dahulu.'
                    );

                    return;
                }


                const labels = {
                    activate:
                        'mengaktifkan',

                    deactivate:
                        'menonaktifkan',

                    publish:
                        'mempublish',

                    draft:
                        'menjadikan draft',

                    delete:
                        'menghapus permanen'
                };


                const actionLabel =
                    labels[
                        bulkAction.value
                    ]
                    ?? 'memproses';


                bulkConfirmText.textContent =
                    'Anda akan '
                    + actionLabel
                    + ' '
                    + checked.length
                    + ' {{ $itemLabel }}. '
                    + 'Lanjutkan?';


                new bootstrap.Modal(
                    document.getElementById(
                        'bulkConfirmModal'
                    )
                ).show();
            }
        );


        bulkConfirmButton.addEventListener(
            'click',
            function () {

                this.disabled =
                    true;

                this.textContent =
                    'Memproses...';

                bulkForm.submit();
            }
        );


        updateSelectedCount();
    }
);
</script>