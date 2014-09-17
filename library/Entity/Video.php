<?php
namespace Entity;
/**
 * @Entity
 * @Table(name="video", options={"collate"="utf8_general_ci"})
 * @HasLifecycleCallbacks()
 */
class Video
{
	/**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** @Column(length=140) */
    private $title;
    /** @Column(length=140) */
    private $url;
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
     * @return Video
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Video
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
     * Set url
     *
     * @param string $url
     *
     * @return Video
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
