import React, { Fragment } from 'react';
import styles from "./Question.module.css"
const QuestionItem = () => {
    return (
        <div className={styles.question}>
            <h5>Question 1</h5>
            <span>PHP by admin</span>
        </div>
    );
}

export default QuestionItem;
