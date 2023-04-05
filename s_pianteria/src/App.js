import './App.css';
import Home from './pages/home.jsx';
import Pianta from './pages/pianta';
import {Routes, Route} from 'react-router-dom';

function App() {
  return (
  <>
    <Routes>
      <Route path={'/'} element={<Home/>}/>
      <Route path={'/pianta'} element={<Pianta/>}/>
    </Routes>
  </>
  );
}

export default App;



