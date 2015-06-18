<?php

namespace Mailchimp\Message\Members;

use Mailchimp\Message\AbstractMessage;

class Notes extends AbstractMessage
{
    /**
     * The note's ID.
     *
     * @var int $note_id Note ID
     */
    private $note_id;

    /**
     * The date the note was created.
     *
     * @var string $created_at Created Time
     */
    private $created_at;

    /**
     * The author of the note.
     *
     * @var string $created_by Author
     */
    private $created_by;

    /**
     * The content of the note.
     *
     * @var string $note Note
     */
    private $note;

    /**
     * @return int
     */
    public function getNoteId()
    {
        return $this->note_id;
    }

    /**
     * @param int $note_id
     */
    public function setNoteId($note_id)
    {
        $this->note_id = $note_id;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param string $created_by
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getEndpoint()
    {
        return false;
    }

    public function getAllowedHttpVerbs()
    {
        return false;
    }

    public function createRequestParams()
    {
        return null;
    }
}