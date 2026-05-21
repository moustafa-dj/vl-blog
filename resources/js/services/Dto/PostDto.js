export function PostDto(post){

    const postData = new FormData()
    postData.append('title',post.title)
    if(post.cover instanceof File) {
        postData.append('cover', post.cover)
    }
    postData.append('content',post.content),
    post.tags.forEach((e , i) =>{
        postData.append(`tags[${i}]`,e)
    })
    
    return postData
}