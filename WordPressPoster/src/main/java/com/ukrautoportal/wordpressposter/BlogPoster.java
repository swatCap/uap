/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.ukrautoportal.wordpressposter;

//import org.apache.xmlrpc.XmlRpcException;
//import org.apache.xmlrpc.client.XmlRpcClient;
/**
 *
 * @author swat
 */
public class BlogPoster {
//
//    private static final String POST_METHOD_NAME = "blogger.newPost";
//
//    private XmlRpcClient client;
//    private BlogInfo blogInfo;
//    private PostType postType = PostType.draft;
//
//    public BlogPoster(XmlRpcClient client, BlogInfo blogInfo) {
//        this.client = client;
//        this.blogInfo = blogInfo;
//    }
//
//    public void setPostType(PostType postType) {
//        this.postType = postType;
//    }
//
//    public Integer post(String contents) throws XmlRpcException {
//        Object[] params = new Object[]{
//            blogInfo.getApiKey(),
//            blogInfo.getBlogId(),
//            blogInfo.getUserName(),
//            blogInfo.getPassword(),
//            contents,
//            postType.booleanValue()
//        };
//        return (Integer) client.execute(POST_METHOD_NAME, params);
//    }
//    
//    public Object get(int postId) throws XmlRpcException {
//        Object[] params = new Object[]{
//            blogInfo.getApiKey(),
//            blogInfo.getBlogId(),
//            blogInfo.getUserName(),
//            blogInfo.getPassword(),
//            postId,
//            postType.booleanValue()
//        };
//        return client.execute("blogger.getPost", params);
//    }
//    
//
//    public static enum PostType {
//
//        publish(true), draft(false);
//
//        private final boolean value;
//
//        PostType(boolean value) {
//            this.value = value;
//        }
//
//        public boolean booleanValue() {
//            return value;
//        }
//    }
}
