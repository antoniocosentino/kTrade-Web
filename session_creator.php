<?
session_start();
include("config.inc.php");

//kprint($_SESSION);
//kprint($_POST);


switch ($_POST['type']) {
    case 'accounts':
        $_SESSION['account_id'] = $_POST['account_id'];

        foreach ($_SESSION['all_accounts_data'] as $single_account) {
        	if ($single_account->accountId == $_POST['account_id']){
        		$_SESSION['account_details'] = $single_account;
        	}
        }
        $_SESSION['all_accounts_data'] = "";
        $redirect_url ="app.php";
    break;

    case 'symbol':
        $_SESSION['selected_symbol'] = $_POST['selected_symbol'];
        $redirect_url ="app.php";
    break;

    case 'mode':
        $_SESSION['selected_mode'] = $_POST['selected_mode'];
        $redirect_url ="app.php";
    break;
}


header("Location: $redirect_url");

?>