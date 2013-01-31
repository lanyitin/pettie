<?php
require_once(CLASS_PATH . DS . "class.Response.php");
require_once(CLASS_PATH . DS . "class.Request.php");
require_once(TPL_CLASS_PATH . "class.TemplateFactory.php");
require_once(PRESENTER_PATH."class.Presenter.php");
require_once(ROOT.DS."functions.php");
require_once(PO_PATH."class.Post.php");
class PresenterBlog extends Presenter
{
	function __construct()
	{
		parent::__construct();
		$request = new Request("api/member/isLogin");
		$this->isLogin = $request->execute();

	}

	private function get_post_list_by_ids($username, $ids) {
		if($username == $_SESSION["username"]){
			$friend_request = new Request("api/friend/list", array($username));
			$friends = $friend_request->execute()->content;
			foreach($friends as $f){
				$ids[] = $f->id;
			}
			$row = Post::getReadedListByUserIds($ids, $this->db);

		}else{
			$row = Post::getListByUsername($username, $this->db);
		}
		return $row;
	}
	private function get_unread_post_list_by_ids($username, $ids) {
		if($username == $_SESSION["username"]){
			$friend_request = new Request("api/friend/list", array($username));
			$friends = $friend_request->execute()->content;
			foreach($friends as $f){
				$ids[] = $f->id;
			}
			$row = Post::getUnreadedListByUserIds($ids, $this->db);
		}else{
			$row = Post::getUnreadListByUsername($username, $this->db);
		}
		return $row;
	}
	protected function api_list($parameters)
	{
		$ids = array($_SESSION["id"]);
		$username=isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$row = $this->get_post_list_by_ids($username, $ids);

		$postids = array();
		foreach($row as $post){
			$postids[] = $post->id;
		}
		$postids = implode(",", $postids);
		$row2 = Post::getCommentsByPostIds($postids,$this->db);
		return new Response(0, array("posts"=>$row, "comments"=>$row2));
	}
	protected function api_unread_list($parameters)
	{
		$ids = array($_SESSION["id"]);
		$username=isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$row = $this->get_unread_post_list_by_ids($username, $ids);
		$postids = array();
		foreach($row as $post){
			$postids[] = $post->id;
		}
		$postids = implode(",", $postids);
		if($postids !== ""){
			$sql = sprintf("insert ignore into READ_POST select {$_SESSION["id"]} as mid, Post.id as pid from Post where Post.id in (%s)", $postids);
			$this->db->query($sql);
			$row2 = Post::getCommentsByPostIds($postids,$this->db);
		}else{
			$row2 = array();
		}
		return new Response(0, array("posts"=>$row, "comments"=>$row2));
	}
	protected function api_friends_list($parameters)
	{
		$ids = array();
		$username=isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$row = $this->get_post_list_by_ids($username, $ids);

		$postids = array();
		foreach($row as $post){
			$postids[] = $post->id;
		}
		$postids = implode(",", $postids);
		$row2 = Post::getCommentsByPostIds($postids,$this->db);
		return new Response(0, array("posts"=>$row, "comments"=>$row2));
	}
	protected function api_friends_unread_list($parameters)
	{
		$ids = array();
		$username=isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$row = $this->get_unread_post_list_by_ids($username, $ids);
		$postids = array();
		foreach($row as $post){
			$postids[] = $post->id;
		}
		$postids = implode(",", $postids);
		if($postids !== ""){
			$sql = sprintf("insert ignore into READ_POST select {$_SESSION["id"]} as mid, Post.id as pid from Post where Post.id in (%s)", $postids);
			$this->db->query($sql);
			$row2 = Post::getCommentsByPostIds($postids,$this->db);
		}else{
			$row2 = array();
		}
		return new Response(0, array("posts"=>$row, "comments"=>$row2));
	}

	protected function handle_post($parameters)
	{
		if(!$this->isLogin){
			redirect("member/login/");
		}
		if(!isset($_POST['content']) || !isset($_POST["type"])){
			$tpl = TemplateFactory::getByFilename("BlogPost.phtml");
			return new Response(0, $tpl);
		}else{
			if($this->api_post($parameters)->isSuccessed())
			{			
				return new Response(0, Post::getById($this->db->lastInsertId(), $this->db));
			}else{
				return new Response(1,"unable to add new post");
			}
		}
	}
	protected function api_post($parameters){
		if(!isset($_POST['content'])||$_POST["content"]===""||!isset($_POST["type"])||$_POST["type"]===""){
			return new Response(1, "Incomplete infos");
		}
		$content = htmlspecialchars($_POST['content'],ENT_COMPAT,'UTF-8', false);
		if(ccStrLen($content)>140)
		{
			return new Response(1,"?z?W?L?r?ƭ???");
		}
		$post = new Post($this->db);

		$post->content =$content;
		$post->mid = $_SESSION['id'];
		$post->type = $_POST["type"];
		$post->save();
		return new Response(0, true);
	}
	protected function handle_post_edit($parameters)//modify a post
	{
		if($this->isLogin){
			if($this->api_post_edit($parameters)->isSuccessed()){
				return new Response(0, true);
			}else{
				$post = Post::getById($parameters[0], $this->db);
				$tpl = TemplateFactory::getByFilename("BlogPostEdit.phtml");
				$tpl->post = $post;
				return new Response(0, $tpl);
			}
		}else{
			redirect("member/login/");
		}
	}
	protected function api_post_edit($parameters)
	{
		if(!isset($_POST["content"])||$_POST["content"]===""||!isset($_POST["type"])||$_POST["type"]===""){
			return new Response(1, false);
		}
		$time =date('y-m-d h:i:s',time());
		$content = htmlspecialchars($_POST['content'],ENT_COMPAT,'UTF-8', false);
		if(strlen($content)>140)
		{
			return new Response(1,"字數不能大於140");
		}
		$post = Post::getById($parameters[0], $this->db);
		$post->content = $content;
		$post->type = $_POST["type"];
		$post->time = $time;
		$post->save();
		return new Response(0, true);
	}

	protected function handle_post_delete($parameters)//delete a post
	{
		if($this->isLogin){
			$this->api_post_delete($parameters);
		}else{
			return new Response(1, false);
		}
	}
	protected function api_post_delete($parameters)
	{	
		$post = Post::getById($parameters[0], $this->db);
		if($post->mid != $_SESSION["id"]){
			return new Response(1,false);
		}
		if($post->reply==0){
			$stmt = $this->db->prepare("DELETE FROM Post WHERE reply =?");
			$stmt->bindValue(1,$parameters[0],PDO::PARAM_STR);
			$stmt->execute() or die(print_r($this->db->errorInfo()));//delete comment
		}	
		$post->delete($this->db);//delete post
		header("HTTP/1.0 204 No Content");
		header("Content-Length: 0");
		header('Content-Type: text/html',true);
		flush();
	}

	protected function handle_post_comment($parameters)
	{
		if(!$this->isLogin){
			redirect("member/login/");
		}
		if(!isset($_POST['content']) || !isset($_POST["type"])){
			$tpl = TemplateFactory::getByFilename("BlogComment.phtml");
			return new Response(0, $tpl);
		}else{
			if($this->api_post_comment($parameters)->isSuccessed())
			{
				$row = Post::getById($parameters[0], $this->db);;
			}else{
				$tpl = TemplateFactory::getByFilename("BlogComment.phtml");
				$this->response = new Response(0, $tpl);
			}
		}
	}
	protected function api_post_comment($parameters)
	{
		if(!isset($_POST['content']) || !isset($_POST["type"])){
			redirect("blog/post/comment/". $parameters[0]);
			return new Response(1, "You should write something!");
		}else{
			$content =htmlspecialchars($_POST['content'],ENT_COMPAT,'UTF-8', false);
			$reply = (int)$parameters[0];
			$post = new Post($this->db);
			$post->mid = $_SESSION["id"];
			$post->content = $content;
			$post->type = $_POST["type"];
			$post->reply = $reply;
			$post->save();
			$post->Pic = $_SESSION["Pic"];
			$post->owner = $_SESSION["username"];
			return new Response(0, $post);

		}
	}
	protected function handle_comment_delete($parameters)
	{
		if($this->isLogin){
			$row2 = Post::getById($parameters[0], $this->db);
			$this->api_post_delete($parameters);
			header("HTTP/1.0 204 No Content");
			header("Content-Length: 0");
			header('Content-Type: text/html',true);
			flush();
		}else{
			redirect("member/login/");
		}
	}

	protected function handle_post_like($parameters)
	{
		if($this->isLogin){
			$this->api_post_like($parameters);
		}
	}
	protected function api_post_like($parameters)
	{
		if($this->isLogin){
			$sql = sprintf("insert into LIKE_POST (mid, pid) values (\"%s\", \"%s\")", $_SESSION["id"], $parameters[0]);
			$this->db->query($sql);
		}
	}
	protected function handle_post_unlike($parameters)
	{
		if($this->isLogin){
			$this->api_post_unlike($parameters);
		}
	}
	protected function api_post_unlike($parameters)
	{
		if($this->isLogin){
			$sql = sprintf("delete from LIKE_POST where mid=\"%s\" AND pid= \"%s\"", $_SESSION["id"], $parameters[0]);
			$this->db->query($sql);
			header("HTTP/1.0 204 No Content");
			header("Content-Length: 0");
			header('Content-Type: text/html',true);
			flush();
		}
	}

	protected function handle_circle($parameters)
	{
		$row = Post::getByGroupid($parameters[0], $this->db);
		$list = array();
		foreach($row as $post){
			$list[] = $post->id;
		}
		$row2 = Post::getCommentsByPostIds($list,$this->db);
		$tpl = TemplateFactory::getByFilename("BlogView.phtml");
		$tpl->posts = $row;
		$tpl->comments = $row2;
		return new Response(0, array("posts"=>$row, "comments"=>$row2));
	}
	protected function handle_liked_list($parameters)
	{
		$username=isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$row = Post::getLikedList($username, $this->db);
		$postids = array();
		foreach($row as $post){
			$postids[] = $post->id;
		}
		$postids = implode(",", $postids);
		$row2 = Post::getCommentsByPostIds($postids,$this->db);
		return new Response(0, array("posts"=>$row, "comments"=>$row2));
	}
	protected function handle_liked_unread($parameters)
	{
		$username=isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$row = Post::getUnreadLiked($username, $this->db);
		$postids = array();
		foreach($row as $post){
			$postids[] = $post->id;
		}
		$postids = implode(",", $postids);
		$row2 = Post::getCommentsByPostIds($postids,$this->db);
		return new Response(0, array("posts"=>$row, "comments"=>$row2));
	}
	protected function handle_search($parameters)
	{
		if (isset($_POST["keyword"])) {
			if ($_POST["type"] == "post") {
				$posts = Post::getListBySearch($_POST["keyword"], $this->db);
				$postids = array();
				foreach($posts as $post) {
					$postids[] = $post->id;
				}
				$comments = Post::getCommentsByPostIds($postids, $this->db);
				return new Response(0, array("posts"=>$posts, "comments"=>$comments));
			} else if ($_POST["type"] == "username") {
				$posts = Post::getListBySearchUsername($_POST["keyword"], $this->db);
				$postids = array();
				foreach($posts as $post) {
					$postids[] = $post->id;
				}
				$comments = Post::getCommentsByPostIds($postids, $this->db);
				return new Response(0, array("posts"=>$posts, "comments"=>$comments));
			}
		} else {
			$tpl = TemplateFactory::getByFilename("BlogSearch.phtml");
			return new Response(0, $tpl);
		}
	}
	protected function handle_comments($parameters)
	{
		$comments = Post::getCommentsByPostIds($parameters[0], $this->db);
		return new Response(0, array("comments" => $comments));
	}
}
?>
