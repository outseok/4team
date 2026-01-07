<?php
session_start();

$dbconn = mysqli_connect('localhost', 'root', '', 'user');
if (!$dbconn) {
    die('DB 연결 실패: ' . mysqli_connect_error());
}

$uid = $_POST['uid'] ?? '';
$upw = $_POST['upw'] ?? '';

if ($uid === '' || $upw === '') {
    echo "<script>
        alert('아이디/비밀번호가 전달되지 않았습니다. 로그인 페이지에서 다시 시도하세요.');
        history.back();
    </script>";
    exit;
}

mysqli_set_charset($dbconn, 'utf8');

$sql = "select * from user_info where uid='$uid' and upw='$upw'";
$result = mysqli_query($dbconn, $sql);

if ($result === false) {
    die('SQL 오류: ' . mysqli_error($dbconn));
}

$row = mysqli_fetch_assoc($result);

if ($row) {
    session_regenerate_id(true);
    $_SESSION['uid'] = $row['uid'];

    echo "<script>
        alert('로그인 성공하였습니다.');
        location.href='main.php?uid=".$uid."';
        location.href='point.php?uid=".$uid."';
        location.href='store.html?uid=".$uid."';
        location.href='record_score.php?uid=".$uid."';
        location.href='buy.php?uid=".$uid."';
        location.href='diary_save.php?uid=".$uid."';
        location.href='content.php?uid=".$uid."';
        
        </script>";
} else {
    echo "<script>
        alert('회원 정보가 일치하지 않습니다. 다시 시도해주세요.');
        history.back();
    </script>";
}

mysqli_close($dbconn);
exit;
?>
