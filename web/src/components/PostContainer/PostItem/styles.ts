import styled from 'styled-components'

export const Container = styled.li`
  box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.08) !important;
  flex-direction: column;
  width: 100%;
  background: #fff;
  border-radius: 6px;
  animation: 1s ease-in-out appear;

  * {
    color: #333;
  }
`

export const Content = styled.div`
  margin: 8px 0;
  padding: 0 14px 14px;
  border-radius: inherit;
`

export const Header = styled.div`
  background: #2766c7;
  border-top-left-radius: 6px;
  border-top-right-radius: 6px;
  border-bottom: 6px solid #254fa0;
  padding: 8px;
  display: flex;
  align-items: center;
  svg {
    font-size: 32px;
    margin: 8px;
    //border: 1px solid #fff;
    border-radius: 6px;
  }
  span {
    font-size: 13px;
  }
  * {
    color: #fff;
  }
`

const Icon = styled.div`
  width: fit-content;
  cursor: pointer;

  :hover {
    filter: brightness(90%);
  }
`

export const StarIcon = styled(Icon)`
  margin-left: auto;
`

export const EditIcon = styled(Icon)``

export const UserAvatar = styled.img`
  width: 54px;
  height: 54px;
  margin: 2px 12px;
  border-radius: 8px;
  border: #f7f7f7 solid 2px;
`
