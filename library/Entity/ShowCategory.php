<?php
namespace Entity;
/**
 * @Entity
 * @Table(name="show_category", options={"collate"="utf8_general_ci"})
 */
class ShowCategory 
{
	/**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /** @Column(length=50) */
    private $name;
    /** @Column(type="smallint", name="total_shows") */
    private $totalShows = 0;//多少节目

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
     * @return ShowCategory
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
     * Set totalShows
     *
     * @param integer $totalShows
     *
     * @return ShowCategory
     */
    public function setTotalShows($totalShows)
    {
        $this->totalShows = $totalShows;

        return $this;
    }

    /**
     * Get totalShows
     *
     * @return integer
     */
    public function getTotalShows()
    {
        return $this->totalShows;
    }
}
