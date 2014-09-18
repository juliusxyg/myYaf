<?php
namespace Entity;
/**
 * @Entity
 * @Table(name="live_video_sort", options={"collate"="utf8_general_ci"})
 */
class LiveVideoSort
{
	/**
     * @Id @Column(type="string", length=32)
     */
    private $hash;
    /** @Column(type="integer") */
    private $weight;

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return LiveVideoSort
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return LiveVideoSort
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
