/**
 * Data structure queue to manage the search history
 */
class QueueDS
{
    constructor()
    {
        this.list = [];
        this.front = 0;
        this.back = 0;
    }

    /**
     * get the collection
     * @returns {[]}
     */
    collection()
    {
        return this.list;
    }

    /**
     * add element to the queue
     * @param element
     * @returns {number}
     */
    enqueue(element)
    {
        return this.list.push(element);
    }

    /**
     * remove the front element from the queue
     * @returns {*}
     */
    dequeue()
    {
        if(this.list.length > 0)
        {
            return this.list.shift();
        }
    }

    /**
     * get the front element
     * @returns {*}
     */
    peek()
    {
        return this.list[this.list.length - 1];
    }

    /**
     * get the length of the queue
     * @returns {number}
     */
    length()
    {
        return this.list.length;
    }

    /**
     * check if queue is empty
     * @returns {boolean}
     */
    isEmpty()
    {
        return this.length === 0;
    }

    /**
     * get specific element from the queue
     * @param index
     * @returns {*}
     */
    getElement(index)
    {
        return this.list[index];
    }

    /**
     * clear the queue
     * @returns {*[]}
     */
    clearList()
    {
        return this.list = [];
    }
}