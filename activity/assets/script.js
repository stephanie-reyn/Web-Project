// Set up the event listeners for the checkboxes
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener for master checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.userCheckbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = document.getElementById('selectAll').checked;
            });
            updateUsersList();
        });

        // Event listener for individual checkboxes
        // var userCheckboxes = document.querySelectorAll('.userCheckbox');
        // userCheckboxes.forEach(function(checkbox) {
        //     checkbox.addEventListener('change', function() {
        //         updateUsersList();
        //     });
        // });

        // // Function to update users list
        // function updateUsersList() {
        //     var selectedUsersContainer = document.getElementById('selectedUsers');
        //     var unselectedUsersContainer = document.getElementById('unselectedUsers');
        //     selectedUsersContainer.innerHTML = '';
        //     unselectedUsersContainer.innerHTML = '';
        //     userCheckboxes.forEach(function(checkbox) {
        //         var username = checkbox.parentNode.textContent.trim();
        //         var listItem = document.createElement('li');
        //         var label = document.createElement('label');
        //         label.textContent = username;
        //         label.appendChild(checkbox.cloneNode(true));
        //         listItem.appendChild(label);
        //         if (checkbox.checked) {
        //             selectedUsersContainer.appendChild(listItem);
        //         } else {
        //             unselectedUsersContainer.appendChild(listItem);
        //         }
        //     });
        // }
    });
