<?php
namespace Entity;
/**
 * @Entity
 * @Table(name="show", options={"collate"="utf8_general_ci"})
 */
class Show 
{
	/**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** @Column(length=50) */
    private $name;
    /** @Column(length=150, name="cover_image") */
    private $coverImage;//栏目图
    /** @Column(type="text") */
    private $story;//故事介绍
    /** @Column(type="smallint", name="is_end") */
    private $isEnd;//是否已完结
    /** @Column(type="smallint", name="is_tv") */
    private $isTv;
    /** @Column(type="smallint", name="season") */
    private $season;//第几季
    /** @Column(type="datetime", name="release_from") */
    private $releaseFrom;//播出日
    /** @Column(type="smallint", name="tv_day") */
    private $tvDay;//tv每周几号播出
    /** @Column(type="smallint", name="tv_number") */
    private $tvNumber;//集数
    /** @Column(type="smallint", name="is_ova") */
    private $isOva;
    /** @Column(type="smallint", name="ova_number") */
    private $ovaNumber;

    /**
     * @ManyToOne(targetEntity="ShowCategory")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     **/
    private $showCategory;

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
     * Set name
     *
     * @param string $name
     *
     * @return Show
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set coverImage
     *
     * @param string $coverImage
     *
     * @return Show
     */
    public function setCoverImage($coverImage)
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * Get coverImage
     *
     * @return string
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     * Set story
     *
     * @param string $story
     *
     * @return Show
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return string
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set isEnd
     *
     * @param integer $isEnd
     *
     * @return Show
     */
    public function setIsEnd($isEnd)
    {
        $this->isEnd = $isEnd;

        return $this;
    }

    /**
     * Get isEnd
     *
     * @return integer
     */
    public function getIsEnd()
    {
        return $this->isEnd;
    }

    /**
     * Set isTv
     *
     * @param integer $isTv
     *
     * @return Show
     */
    public function setIsTv($isTv)
    {
        $this->isTv = $isTv;

        return $this;
    }

    /**
     * Get isTv
     *
     * @return integer
     */
    public function getIsTv()
    {
        return $this->isTv;
    }

    /**
     * Set season
     *
     * @param integer $season
     *
     * @return Show
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return integer
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set releaseFrom
     *
     * @param \DateTime $releaseFrom
     *
     * @return Show
     */
    public function setReleaseFrom($releaseFrom)
    {
        $this->releaseFrom = $releaseFrom;

        return $this;
    }

    /**
     * Get releaseFrom
     *
     * @return \DateTime
     */
    public function getReleaseFrom()
    {
        return $this->releaseFrom;
    }

    /**
     * Set tvDay
     *
     * @param integer $tvDay
     *
     * @return Show
     */
    public function setTvDay($tvDay)
    {
        $this->tvDay = $tvDay;

        return $this;
    }

    /**
     * Get tvDay
     *
     * @return integer
     */
    public function getTvDay()
    {
        return $this->tvDay;
    }

    /**
     * Set tvNumber
     *
     * @param integer $tvNumber
     *
     * @return Show
     */
    public function setTvNumber($tvNumber)
    {
        $this->tvNumber = $tvNumber;

        return $this;
    }

    /**
     * Get tvNumber
     *
     * @return integer
     */
    public function getTvNumber()
    {
        return $this->tvNumber;
    }

    /**
     * Set isOva
     *
     * @param integer $isOva
     *
     * @return Show
     */
    public function setIsOva($isOva)
    {
        $this->isOva = $isOva;

        return $this;
    }

    /**
     * Get isOva
     *
     * @return integer
     */
    public function getIsOva()
    {
        return $this->isOva;
    }

    /**
     * Set ovaNumber
     *
     * @param integer $ovaNumber
     *
     * @return Show
     */
    public function setOvaNumber($ovaNumber)
    {
        $this->ovaNumber = $ovaNumber;

        return $this;
    }

    /**
     * Get ovaNumber
     *
     * @return integer
     */
    public function getOvaNumber()
    {
        return $this->ovaNumber;
    }

    /**
     * Set showCategory
     *
     * @param \Entity\ShowCategory $showCategory
     *
     * @return Show
     */
    public function setShowCategory(\Entity\ShowCategory $showCategory = null)
    {
        $this->showCategory = $showCategory;

        return $this;
    }

    /**
     * Get showCategory
     *
     * @return \Entity\ShowCategory
     */
    public function getShowCategory()
    {
        return $this->showCategory;
    }
}
