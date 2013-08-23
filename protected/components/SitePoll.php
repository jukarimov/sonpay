<?php

class SitePoll
{
	public function getPollSubject($poll) {

		$dao = Yii::app()->db;

		$sql = 'select * from sitepoll_polls where id = :poll';

		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":poll", $poll, PDO::PARAM_INT);

		$cmd->execute();

		$row = $cmd->queryRow();

		return $row['subject'];
	}

	public function postVote($poll, $vote)
	{
		$dao = Yii::app()->db;

		$sql = 'insert into sitepoll_votes(option_id, poll_id) values';
		$sql .= '(:poll, :vote)';

		$cmd = $dao->createCommand($sql);

		$cmd->bindParam(":poll", $poll, PDO::PARAM_INT);
		$cmd->bindParam(":vote", $vote, PDO::PARAM_INT);

		$cmd->execute();
	}

	public function getResults($poll)
	{
		$dao = Yii::app()->db;

		$sql = 'select so.title, floor((count(*) * 100)/(select count(*) from sitepoll_options so join sitepoll_votes sv on so.id = sv.option_id where so.poll_id=:poll)) as hits from sitepoll_votes sv join sitepoll_polls sp on sv.poll_id=sp.id join sitepoll_options so on sv.option_id=so.id group by so.title order by hits;';

		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":poll", $poll, PDO::PARAM_INT);

		$cmd->execute();

		$data = $cmd->query();

		return $data;
	}
}

?>
