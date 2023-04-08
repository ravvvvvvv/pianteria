import './App.css';
import Home from './pages/home.jsx';
import Pianta from './pages/pianta';
import Orders from './pages/orders';
import Adoptions from './pages/adoptions';
import Catalog from './pages/catalog';
import Order_Details from './pages/order_details';
import Shipments from './pages/shipments';
import User_Details from './pages/user_details';
import Login from './pages/login';
import Modify_Password from './pages/modify_password';
import {Routes, Route} from 'react-router-dom';

function App() {
  return (
  <>
    <Routes>
      <Route path={'/'} element={<Home/>}/>
      <Route path={'/pianta'} element={<Pianta/>}/>
      <Route path={'/Orders'} element = {<Orders/>}/>
      <Route path={'/Adoptions'} element = {<Adoptions/>}/>
      <Route path={'/Catalog'} element = {<Catalog/>}/>
      <Route path={'/Order_Details'} element ={<Order_Details/>}/>
      <Route path={'/Shipments'} element = {<Shipments/>}/>
      <Route path={'/User_Details'} element = {<User_Details/>}/>
      <Route path={'/Login'} element = {<Login/>}/>
      <Route path={'/Modify_Password'} element = {<Modify_Password/>}/>
    </Routes>
  </>
  );
}

export default App;



