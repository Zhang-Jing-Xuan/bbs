<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/is_manage_login.inc.php';
if(!is_manage_login($link)){
	skip('login.php','error','请先登录');
	exit();
}
$template['title']='子板块添加页';
$template['css']=array('style/public.css');
if(isset($_POST['submit'])){
	//验证用户填写的内容
	$check_flag='add';
	include 'inc/check_son_module.inc.php';
	$query="insert into son_module(father_module_id,module_name,info,member_id,sort) values({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']});";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('son_module.php','ok','恭喜你添加成功');
		exit();
    }else{
		skip('son_module_add.php','error','对不起，添加失败');
		exit();
    }
}
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
    <div class="title">添加子板块</div>
    <form method="post">
        <table class="au">
            <tr>
				<td>所属父板块</td>
				<td>
					<select name="father_module_id"> 
                        <option value="0">请选择一个父板块</option>
						<?php
							$query="select * from father_module";
							$result_father=execute($link,$query);
							while($data_father=mysqli_fetch_assoc($result_father)){
									echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
							}
						?>
                    </select>
				</td>
				<td>
					必须选择一个所属的父板块
				</td>
			</tr>
			<tr>
				<td>版块名称</td>
				<td><input name="module_name" type="text" /></td>
				<td>
					板块名称不得为空，最大不得超过66个字符
				</td>
			</tr>
            <tr>
				<td>简介信息</td>
				<td>
                    <textarea name="info"></textarea>
                </td>
				<td>
					板块简介不得为空，最大不得超过255个字符
				</td>
			</tr>
            <tr>
				<td>您可以选择一个会员作为版主</td>
				<td>
					<select name="member_id"> 
                        <option value="0">请选择一个会员</option>
                    </select>
				</td>
				<td>
					必须选择一个所属的父板块
				</td>
			</tr>
			<tr>
				<td>排序</td>
				<td><input name="sort" value="0" type="text" /></td>
				<td>
					填写一个数字
				</td>
			</tr>
        </table>
        <input style="cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php include 'inc/footer.inc.php' ?>