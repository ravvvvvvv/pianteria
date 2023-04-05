import { Link } from "react-router-dom";

function NavBar() {

    return(
        <>
            <nav className="nav">
                <a href="/" style={{textDecoration: 'none',borderStyle: 'none'}}> 
                    <div className="logo">
                        <h1 style={{ color: "#000000"}}>Pianteria</h1>
                    </div>
                </a>
                <div>
                    <CustomLink href={'/pianta'}>Piante</CustomLink>
                </div>
            </nav>
        </>
    );
}

function CustomLink({href, children}) {
    const path = window.location.pathname
    return (
        <li>
            <a className={path == href ? "active" : ""} href={href} >{children}</a>
        </li>
    )
}

export default NavBar;