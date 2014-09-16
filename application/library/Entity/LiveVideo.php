<?php
namespace Entity;
/**
 * @Entity
 * @Table(name="live_video", options={"collate"="utf8_general_ci"})
 * @HasLifecycleCallbacks()
 */
class LiveVideo
{
	/**
     * @Id @Column(type="integer")
     * @GeneratedValue
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

    /** @PrePersist */
    public function doOnPrePersist()
    {
        $this->createdAt = new \DateTime("now");//注意这里，因为有namespace，php的方法都在根域下
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
     * @return LiveVideo
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
     * @return LiveVideo
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
     * @return LiveVideo
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
     * @return LiveVideo
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return LiveVideo
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
     * Set game
     *
     * @param string $game
     *
     * @return LiveVideo
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
}
