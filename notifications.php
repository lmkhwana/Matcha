<?php
    require 'required/functions.php'; Is_Not_Connected();

    $notiNbr = 0;
    require '/required/database.php';
    $req = $pdo->query('SELECT * FROM notifications WHERE receiver =' .intval($_SESSION['auth']->id));
    $notiNbr = $req->rowCount();


?>
<link rel="stylesheet" type="text/css" href="/css/notif.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <div id="reloadme" class="notifclass" style="background-color: transparent!important;">
        <ul>
            <li id="noti_Container"> 
                <div id="noti_Counter"></div>   <!--SHOW NOTIFICATIONS COUNT.-->

                
                <!--A CIRCLE LIKE BUTTON TO DISPLAY NOTIFICATION DROPDOWN.-->
                <div id="noti_Button" style="z-index: 99999999;"><i class="fa fa-bell" aria-hidden="true"></i></div>

                <!--THE NOTIFICAIONS DROPDOWN BOX.-->
                <div id="notifications">
                    <h3>Notifications</h3>
                    <div style="height:300px;">
                        <?php
                            if ($notiNbr)
                             {
                                $res = $req->fetchall();
                                foreach ($res as $key) {
                                    echo $key->text ."<br>";
                                }
                                $pdo->query('DELETE FROM notifications WHERE receiver=' .intval($_SESSION['auth']->id));
                             }
                        ?>
                    </div>
                    <div class="seeAll"><a href="#" style="color: black!important">See All</a></div>
                </div>
            </li>
        </ul>
    </div>
</body>

<script>
    $(document).ready(function () {
        var nb = Number(<?php echo $notiNbr; ?>);
        // ANIMATEDLY DISPLAY THE NOTIFICATION COUNTER.
        if (nb == 0) {
            $('#noti_Counter')
            .css({ opacity: 0 })
            .css({ display: hidden })
            .text(nb)              // ADD DYNAMIC VALUE (YOU CAN EXTRACT DATA FROM DATABASE OR XML).
            .css({ top: '-10px' })
            .animate({ top: '-2px', opacity: 1 }, 500);
        }
        else
        {
             $('#noti_Counter')
            .css({ opacity: 0 })
            .text(nb)              // ADD DYNAMIC VALUE (YOU CAN EXTRACT DATA FROM DATABASE OR XML).
            .css({ top: '-10px' })
            .animate({ top: '-2px', opacity: 1 }, 500);
        }


        $('#noti_Button').click(function () {

            // TOGGLE (SHOW OR HIDE) NOTIFICATION WINDOW.
            $('#notifications').fadeToggle('fast', 'linear', function () {
                if ($('#notifications').is(':hidden')) {
                    $('#noti_Button').css('background-color', '#2E467C');
                }
                else $('#noti_Button').css('background-color', '#FFF');        // CHANGE BACKGROUND COLOR OF THE BUTTON.
            });

            $('#noti_Counter').fadeOut('slow');                 // HIDE THE COUNTER.

            return false;
        });
        if ($('#notifications').is(':hidden')) {
            setInterval(function()
            {
                $("#reloadme").load("/notifications.php",function(){});   
                },5000);
            });
        }

        // HIDE NOTIFICATIONS WHEN CLICKED ANYWHERE ON THE PAGE.
        $(document).click(function () {
            $('#notifications').hide();

            // CHECK IF NOTIFICATION COUNTER IS HIDDEN.
            if ($('#noti_Counter').is(':hidden')) {
                // CHANGE BACKGROUND COLOR OF THE BUTTON.
                $('#noti_Button').css('background-color', '#2E467C');
            }
        });

        $('#notifications').click(function () {
            return false;       // DO NOTHING WHEN CONTAINER IS CLICKED.
        });
</script>