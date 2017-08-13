<?php
class Note
{
    public static function find($id)
    {
        $query = DB::prepare('SELECT * FROM posts WHERE id=? LIMIT 1');
        $query->execute([$id]);
        $note = $query->fetch(PDO::FETCH_ASSOC);
        if (!$note) {
            return;
        }

        $note['content'] = '';

        $query = DB::prepare('SELECT version_id, fragment FROM post_contents WHERE post_id=? ORDER BY version_id DESC, id ASC');
        $query->execute([$id]);
        $versionId = 0;
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $rs) {
            if (!$versionId) {
                $versionId = (int) $rs['version_id'];
            }
            if ($versionId != $rs['version_id']) {
                break;
            }
            $note['content'] .= $rs['fragment'];
        }

        return $note;
    }

    public static function getTitle($id, $emptyTitle='空笔记')
    {
        $query = DB::prepare('SELECT fragment FROM post_contents WHERE post_id=? ORDER BY version_id DESC, id ASC lIMIT 1');
        $query->execute([$id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result or empty($result['fragment'])) {
            return $emptyTitle;
        }
        $paragraphs = explode("\n", $result['fragment']);
        return mb_substr($paragraphs[0], 0, 64);
    }
}
