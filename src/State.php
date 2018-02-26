<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Heshen;

class State
{
    const TYPE_INITIAL = 'initial';

    const TYPE_NORMAL = 'normal';

    const TYPE_FINAL = 'final';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * State constructor.
     *
     * @param string $name
     * @param string $type
     */
    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isInitial(): bool
    {
        return $this->type === self::TYPE_INITIAL;
    }

    /**
     * @return bool
     */
    public function isNormal(): bool
    {
        return $this->type === self::TYPE_NORMAL;
    }

    /**
     * @return bool
     */
    public function isFinal(): bool
    {
        return $this->type === self::TYPE_FINAL;
    }
}
