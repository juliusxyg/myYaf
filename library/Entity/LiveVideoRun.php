<?php
namespace Entity;
/**
 * @Entity
 * @Table(name="live_video_run", options={"collate"="utf8_general_ci", "engine"="memory"})
 */
class LiveVideoRun
{
	/**
     * @Id @Column(type="integer")
     */
    private $id;
    /** @Column(length=255) */
    private $title;
    /** @Column(length=255) */
    private $img;
    /** @Column(length=50) */
    private $source;
    /** @Column(length=255) */
    private $vurl;
    /** @Column(length=20) */
    private $game;
    /** @Column(type="datetime", name="created_at") */
    private $createdAt;
    /** @Column(type="integer") */
    private $weight;

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return LiveVideoRun
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return LiveVideoRun
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return LiveVideoRun
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return LiveVideoRun
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set vurl
     *
     * @param string $vurl
     *
     * @return LiveVideoRun
     */
    public function setVurl($vurl)
    {
        $this->vurl = $vurl;

        return $this;
    }

    /**
     * Get vurl
     *
     * @return string
     */
    public function getVurl()
    {
        return $this->vurl;
    }

    /**
     * Set game
     *
     * @param string $game
     *
     * @return LiveVideoRun
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return string
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return LiveVideoRun
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return LiveVideoRun
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
