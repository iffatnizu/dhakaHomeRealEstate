<div class="container">
    <div class="">
        <h3><i class="glyphicon glyphicon-user"></i> User Profile</h3>
        <table class="table table-hover" style="width: 100%">
            <tr>
                <td>User Name :</td> 
                <td><?php echo $userProfile[dbConfig::TABLE_USER_ATT_USER_USERNAME]; ?></td>
            </tr>    
            <tr>
                <td>First Name : </td> 
                <td><?php echo $userProfile[dbConfig::TABLE_USER_ATT_USER_FIRSTNAME]; ?></td>
            </tr>    
            <tr>
                <td>Last Name : </td> 
                <td><?php echo $userProfile[dbConfig::TABLE_USER_ATT_USER_LASTNAME]; ?></td>
            </tr> 
            <tr>
                <td>Email : </td> 
                <td><?php echo $userProfile[dbConfig::TABLE_USER_ATT_USER_EMAIL]; ?></td>
            </tr>
            <tr>
                <td>Privilege : </td> 
                <td><?php echo $userProfile[dbConfig::TABLE_USER_PRIVILEDGE_ATT_NAME]; ?></td>
            </tr>
            <tr>
                <td><a href="<?php echo base_url().siteConfig::CONTROLLER_USER.siteConfig::METHOD_USER_PROFILE_EDIT.$userProfile[dbConfig::TABLE_USER_ATT_USER_ID] ?>" class="btn btn-info">Edit Profile</a></td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
</div>