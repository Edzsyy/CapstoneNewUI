<?php 
include('../employee/assets/config/dbconn.php');
include('../employee/assets/inc/header.php');

?> 





<!--YOUR CONTENTHERE-->
<div class="fix-table-header">
    <h4>Registered Business List (Approved Only)</h4>
</div>
<div class="table-container-form">
    <div class="table-container table-form">
        <div class="table-body ">
            <table id="myTable" class=" table-striped table-bordered">
                <tbody>
                    <div id="displayRegisteredBusinessDataTable">
                        <!-- Registered business data will be displayed here -->
                    </div>
                </tbody>
            </table>
        </div>
    </div>
</div>













<?php 
include('../employee/assets/inc/footer.php');
?> 

<script>
        $(document).ready(function() {
            displayRegisteredBusinessData(); // Initial load for registered businesses
            setInterval(() => {
                displayRegisteredBusinessData(); // Refresh every 60 seconds
            }, 60000); 
        });

        // Function to fetch all registered business data
        function displayRegisteredBusinessData() {
            $.ajax({
                url: "business_approve_data_list_table.php", 
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Filter data to show only businesses with document_status = 'Released'
                    let releasedBusinesses = data.filter(business => business.document_status === 'Released');

                    let displayHTML = `<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Business Name</th>
                                <th>Business Address</th>
                                <th>Business Type</th>
                                <th>Date of Application</th>
                                <th>Application Status</th>
                                <th>Expiration Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    // Loop through released businesses and display them
                    releasedBusinesses.forEach(business => {
                        let statusClass = '';
                        switch (business.display_status) {
                            case 'Active':
                                statusClass = 'text-success';
                                break;
                            case 'Expired':
                                statusClass = 'text-danger';
                                break;
                            case 'Needs Renewal':
                                statusClass = 'text-warning';
                                break;
                            case 'N/A':
                                statusClass = 'text-secondary';
                                break;
                            default:
                                statusClass = 'text-secondary';
                        }

                        displayHTML += `<tr>
                            <td>${business.email}</td>
                            <td>${business.business_name}</td>
                            <td>${business.business_address}</td>
                            <td>${business.business_type}</td>
                            <td>${business.date_application}</td>
                            <td>${business.document_status}</td>
                            <td>${business.expiration_date || 'N/A'}</td>
                            <td class="${statusClass}">${business.display_status}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="actionMenu${business.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class='bx bx-dots-vertical-rounded'></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="actionMenu${business.id}">
                                        <a class="dropdown-item" href="view_registered_business.php?id=${business.id}">View</a>
                                        <a class="dropdown-item" href="renew_registered_business.php?id=${business.id}">Renew</a>
                                        <a class="dropdown-item" href="document_view.php?id=${business.id}">Document View</a>
                                        <a class="dropdown-item" href="document_view.php?id=${business.id}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                    });

                    displayHTML += `</tbody></table>`;

                    // Update the content
                    $('#displayRegisteredBusinessDataTable').html(displayHTML);
                },
                complete: function() {
                    setTimeout(() => {
                        displayRegisteredBusinessData(); // Refresh every 60 seconds
                    }, 60000);
                }
            });
}
</script>

</body>
</html>
