<?php
$confirmation = "<script>
                        var confirmation = confirm('Are you sure you want to delete your account?');
                        if (confirmation) {
                            window.location.href = 'delete-backend.php';
                        } else {
                            window.location.href = 'booking.php';
                        }
                    </script>";
echo $confirmation;
?>