import React from 'react';
import Logo from './Logo';
import Container from "react-bootstrap/Container";
import "../../pages/MainPage/main-page.css"

const Header = () => (
   <Container className="mx-auto">
    <header>
        <div className="fl">
            <button type="button">
                <a href="bookmarks">
                <img
                   className="image-fluid"
                   src="/images/misc/user.png"
                   alt="Bookmarks" />
                </a>
            </button>
        </div>

        <div className="fl">
            <Logo />
        </div>
    </header>
   </Container>
)

export default Header;