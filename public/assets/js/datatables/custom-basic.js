$(document).ready(function () {
    $("product-list").DataTable();
    const userTable = $("#basic-1").DataTable({
        columnDefs: [
            { width: "7%", targets: 0, sortable: false },
            { width: "10%", targets: 3, sortable: false },
            { width: "5%", targets: 4, sortable: false },
            { width: "15%", targets: 5, sortable: false },
            { width: "5%", targets: 6, sortable: false },
        ],
    });

    userTable.columns.adjust().draw();

    $(document).on("click", "#checkAllUsers", function () {
        var rows = userTable.rows({ search: "applied" }).nodes();
        $('input[type="checkbox"]', rows).prop("checked", this.checked);
        handleSelectAllBox();
    });

    $("#basic-1 tbody").on("change", 'input[type="checkbox"]', function () {
        handleSelectAllBox();
    });

    const handleSelectAllBox = () => {
        const checkBoxInputs = $(
            '#basic-1 tbody input[type="checkbox"]:checked'
        );
        if (checkBoxInputs?.length > 0) {
            $("#deleteAllUserBtn").removeClass("d-none");
            $(
                "#deleteAllUserBtn"
            )[0].innerHTML = `<span class="d-flex align-items-center gap-1"><i class="fa fa-trash"></i> <span>Delete Users</span> (${checkBoxInputs?.length})</span>`;
        } else {
            $("#deleteAllUserBtn").addClass("d-none");
        }

        $("#checkAllUsers")[0].checked = checkBoxInputs?.length == 10;
    };

    $(document).on("click", "#deleteAllUserBtn", function () {
        const deleteForm = document.getElementById("deleteUserForm");
        const inputs = document.getElementById("usersId");
        deleteForm.querySelector('input[name="_method"]').value = "POST";

        var selectedIds = [];
        $('#basic-1 tbody input[type="checkbox"]:checked').each(function () {
            selectedIds.push($(this).val());
        });
        inputs.value = selectedIds;

        const url = window.location.href.split("?")[0];
        deleteForm.action = `${url}/delete-all`;

        const deleteModal = new bootstrap.Modal(
            document.getElementById("deleteUserModel")
        );
        deleteModal.show();
    });
});
